<?php

namespace Tests\Feature\Backstage\Campaigns;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function aVisitorCannotSeeTheCreateView(): void
    {
        $response = $this->get(route('backstage.campaigns.create'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function aUserThatIsNotAnAdminCannotSeeTheCreateView(): void
    {
        $this->signIn();

        $response = $this->get(route('backstage.campaigns.create'));
        $response->assertForbidden();
    }

    /** @test */
    public function anAdminUserCanSeeTheCreateView(): void
    {
        $this->signInAsAdmin();

        $response = $this->get(route('backstage.campaigns.create'));
        $response->assertOk();
    }

    /** @test */
    public function anAdminUserCanCreateACampaign(): void
    {
        $this->withoutExceptionHandling();

        $this->signInAsAdmin();

        $campaign = make(Campaign::class);

        $response = $this->post(route('backstage.campaigns.store'), $campaign->toArray());

        $this->assertDatabaseHas('campaigns', [
            'name' => $campaign->name,
            'targeting' => $campaign->targeting,
            'segmentation' => $campaign->segmentation,
        ]);

        $response->assertRedirect(route('backstage.campaigns.index'))
            ->assertSessionHas('success', 'The campaign has been created!');
    }
}
