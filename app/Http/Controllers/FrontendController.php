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
        if (request('spins')) {
            $game->spins_limit = request('spins');
            $game->save();
        }

        return view('frontend.game', compact('campaign', 'game'));
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}
