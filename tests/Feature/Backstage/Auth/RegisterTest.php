<?php

namespace Tests\Feature\Backstage\Auth;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /** @test */
    public function aVisitorCannotViewARegistrationForm()
    {
        $response = $this->get('/backstage/register');

        $response->assertStatus(404);
    }
}
