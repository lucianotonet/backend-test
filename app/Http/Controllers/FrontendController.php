<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class FrontendController extends Controller
{
    public function loadCampaign(Campaign $campaign)
    {
        return view('frontend.game', compact('campaign'));
    }

    public function placeholder()
    {
        return view('frontend.placeholder');
    }
}
