<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Game;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function loadCampaign(Campaign $campaign)
    {
        $game = Game::whereDate('created_at', '=', Carbon::today()->setTimezone($campaign->timezone)->toDateString())            
            ->updateOrCreate([
                'account' => request('a'),
                'campaign_id' => $campaign->id
            ], [
                'revealed_at' => Carbon::today()->setTimezone($campaign->timezone)->now(),
            ]);

        // Just for simplicity
        // It reset the counter to 0
        if (request('spins')) {
            $game->spins_limit = request('spins');
            $game->spins_count = 0;
            $game->save();
        }

        return view('frontend.game', compact('campaign', 'game'));
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}
