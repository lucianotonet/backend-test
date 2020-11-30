<?php

namespace App\Exceptions\Frontend\Campaigns;

use App\Models\Campaign;
use Exception;

class EndedException extends Exception
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

        // Add message to base config
        $config['error'] = $this->texts_array['campaign_ended'] ?? 'campaign_ended';

        // Return the view
        return view('frontend.start', [
            'config' => json_encode($config),
        ]);
    }
}
