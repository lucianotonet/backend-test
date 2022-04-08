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
        if ($game->spins_limit == 0) {
            return response()->json([
                'error' => "You don't have more spins today. Please come back tomorrow and try again."
            ]);
        }

        // Update spins 
        $game->spins_limit = $game->spins_limit - 1;
        $game->revealed_at = Carbon::today()->setTimezone($campaign->timezone)->now();
        $game->save();

        // get all symbols ids
        $symbols = Symbol::all()->pluck('id')->toArray();

        $symbolIds = [];

        // get 15 random items from symbols
        for ($i = 0; $i < 15; $i++) {
            $symbolIds[] = $symbols[array_rand($symbols, 1)];
        }

        $return = [
            'symbols'       => array_chunk($symbolIds, 5), // splitted 5x3 array 
            'points'        => 0,
            'spins_remain'  => $game->spins_limit
        ];

        return $return;
    }
}
