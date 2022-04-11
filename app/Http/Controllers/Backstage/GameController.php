<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backstage\Campaigns\UpdateRequest;
use App\Models\Campaign;
use App\Models\Game;
use App\Models\Symbol;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backstage.games.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Campaign $campaign)
    {
        //
    }

    // return a 5x3 array with random symbols
    public function spin(Campaign $campaign)
    {
        $game = Game::whereDate('created_at', '=', Carbon::today()->setTimezone($campaign->timezone)->toDateString())
            ->where([
                'account' => request('a'),
                'campaign_id' => $campaign->id
            ])
            ->first();

        // check spins limit
        if ($game->spins_count == $game->spins_limit) {
            return response()->json([
                'error' => "You don't have more spins today. Please come back tomorrow and try again."
            ]);
        }

        // Update spins 
        $game->spins_count = $game->spins_count + 1;
        $game->revealed_at = Carbon::today()->setTimezone($campaign->timezone)->now();
        // $game->save();

        // get all symbols ids
        $symbols = Symbol::all();
        $symbolIds = $symbols->pluck('id')->toArray();

        $randomSymbolIds = [];
        $randomSymbols = [];

        // get 15 random items from symbols
        for ($i = 0; $i < 15; $i++) {
            $randomSymbolIds[] = $symbolIds[array_rand($symbolIds, 1)];
            $randomSymbols[] = $symbols->where('id', $randomSymbolIds[$i])->first();
        }

        // check for matches        
        $resultMatches = $this->checkMatches($randomSymbolIds);

        // get the best match
        $maxPoints = 0;
        $bestMatch = [];
        foreach ($resultMatches as $match) {
            if (isset($match['match_times']) && $match['match_times'] > $maxPoints) {
                $maxPoints = $match['points'];
                $bestMatch = $match;
            }
        }

        // prepare response
        $total_points = $game->total_points + ($bestMatch['points'] ?? 0);
        $response = [
            'symbol_ids'    => array_chunk($randomSymbolIds, 5), // splitted 5x3 array 
            'symbol_objs'   => array_chunk($randomSymbols, 5), // splitted 5x3 array
            'points'        => floatval($bestMatch['points'] ?? 0),
            'total_points'  => $total_points,
            'spins_remain'  => $game->spins_limit - $game->spins_count,
            'all_matches'   => $resultMatches,
            'best_match'    => $bestMatch,
        ];

        // save spins history
        $spins_history = json_decode($game->spins_history);
        $spins_history[] = array_merge(
            $response,
            [
                'date' => Carbon::now()->setTimezone($campaign->timezone)->toDateTimeString(), // just for history log
            ]
        );

        $game->spins_history = $spins_history;
        $game->total_points = $total_points;
        $game->save();

        // return response
        return $response;
    }

    private function checkMatches($line)
    {
        // all possible payline indexes
        $paylineIndexes = [
            [1, 2, 3, 4, 5],
            [6, 7, 8, 9, 10],
            [11, 12, 13, 14, 15],
            [1, 7, 13, 9, 5],
            [11, 7, 3, 9, 15],
            [6, 2, 3, 4, 10],
            [6, 12, 13, 14, 10],
            [1, 2, 8, 14, 15],
            [11, 12, 8, 4, 5],
        ];

        $ids = [];

        foreach ($paylineIndexes as $i => $payline) {
            foreach ($payline as $lineIndex) {
                $ids[$i][] = $line[$lineIndex - 1];
            }
        }

        // count matches
        $matchesCount = [];
        $lastId = null;

        foreach ($ids as $lineIndex => $lineValues) {
            $matchesCount[] = [];

            foreach ($lineValues as $row => $id) {
                $matchesCount[$lineIndex][$row] = 1;
                if ($id == $lastId) {
                    $matchesCount[$lineIndex][$row] = $matchesCount[$lineIndex][$row - 1] + 1;
                }
                $lastId = $id;
            }

            $lastId = null;
        }

        // get winning symbols
        $winningSymbols = [];
        foreach ($matchesCount as $i => $matches) {
            $winningSymbols[] = null;
            if (in_array(5, $matches)) {
                $symbol_id = $ids[$i][array_search(5, $matches)];
                $symbol = Symbol::find($symbol_id);
                $winningSymbols[$i] = [
                    'match_symbol' => $symbol,
                    'match_times' => 5,
                    'payline' => $paylineIndexes[$i],
                    'points' => $symbol->x5_points
                ];
            } else if (in_array(4, $matches)) {
                $symbol_id = $ids[$i][array_search(4, $matches)];
                $symbol = Symbol::find($symbol_id);
                $winningSymbols[$i] = [
                    'match_symbol' => $symbol,
                    'match_times' => 4,
                    'payline' => $paylineIndexes[$i],
                    'points' => $symbol->x4_points
                ];
            } else if (in_array(3, $matches)) {
                $symbol_id = $ids[$i][array_search(3, $matches)];
                $symbol = Symbol::find($symbol_id);
                $winningSymbols[$i] = [
                    'match_symbol' => $symbol,
                    'match_times' => 3,
                    'payline' => $paylineIndexes[$i],
                    'points' => $symbol->x3_points
                ];
            }
        }

        return array_filter($winningSymbols);
    }
}
