<?php

namespace App\Exceptions\Frontend\Campaigns;

use App\Models\Campaign;
use Exception;

class PlayerNotFoundException extends Exception
{
    /**
     * @var Campaign
     */
    private Campaign $campaign;

    public static function with(Campaign $campaign)
    {
        $ex = new self();
        $ex->campaign = $campaign;

        return $ex;
    }

    public function render()
    {
        // Load base config
        $config = $this->campaign->getConfig();
        $text = $this->campaign->texts()->where('name', 'player_not_found')->first();

        // Add message to base config
        $config['error'] = $text->value ?? 'player_not_found';

        // Return the view
        return view('frontend.start', [
            'config' => json_encode($config),
        ]);
    }
}
