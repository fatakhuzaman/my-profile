<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Log in as a user listed in ADMIN_EMAILS, so the CMS panel lets them in.
     */
    protected function actingAsAdmin(): User
    {
        $admin = User::factory()->create();

        config(['app.admin_emails' => [$admin->email]]);

        $this->actingAs($admin);

        return $admin;
    }
}
