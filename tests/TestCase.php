<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class, [
            'level' => 'readonly',
        ]);

        $this->actingAs($user);

        return $this;
    }

    protected function signInAsAdmin($user = null)
    {
        $user = $user ?: create(User::class, [
            'level' => 'admin',
        ]);

        $this->actingAs($user);

        return $this;
    }
}
