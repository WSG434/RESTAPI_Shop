<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    protected User $currentUser;

    protected function signIn(bool $isAdmin = true): void
    {
        $this->currentUser = User::factory()->createOne(['is_admin' => true]);
        Sanctum::actingAs($this->currentUser);
    }

    protected function currentUserId(): int
    {
        return $this->currentUser->id;
    }
}
