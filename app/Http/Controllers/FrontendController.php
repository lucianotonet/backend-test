<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class FrontendController extends Controller
{
    private $username;

    public function loadCampaign(Campaign $campaign)
    {
        $game = null;
        $account = request('a'); //set as url param
        $level = request('l');

        //create game based on user level
        //high level users should always have between 140 and 180 points
        //medium level users should always have between 80 and 139 points
        //low level users should always have between 0 and 79 points

        return view('frontend.index')
            ->with('data', $game);
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }

}
