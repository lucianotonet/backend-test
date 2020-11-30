<?php

use App\Models\Campaign;
use App\Models\Prize;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Test',
            'email' => 'test@thunderbite.com',
            'level' => 'full',
            'password' => Hash::make('test123'),
        ]);

        $start = \Carbon\Carbon::now()->startOfDay();
        $end = \Carbon\Carbon::now()->addDays(7)->endOfDay();
        $campaign = Campaign::create([
            'timezone' => 'Europe/London',
            'name' => 'Darts',
            'start_date' => $start,
            'end_date' => $end,
        ]);

        $campaign = Campaign::create([
            'timezone' => 'Europe/London',
            'name' => '5 Reels Slots',
            'start_date' => $start,
            'end_date' => $end,
        ]);

        Prize::insert([
            [
                'campaign_id' => $campaign->id,
                'title' => 'Low 1',
                'level' => 'low',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Low 2',
                'level' => 'low',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Low 3',
                'level' => 'low',
                'weight' => '50.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Med 1',
                'level' => 'med',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Med 2',
                'level' => 'med',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Med 3',
                'level' => 'med',
                'weight' => '50.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'High 1',
                'level' => 'high',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'High 2',
                'level' => 'high',
                'weight' => '25.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'High 3',
                'level' => 'high',
                'weight' => '50.00',
                'startDate' => $start,
                'endDate' => $end,
            ],
        ]);
    }
}
