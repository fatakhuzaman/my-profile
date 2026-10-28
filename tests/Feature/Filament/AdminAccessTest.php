<?php

namespace Tests\Feature\Filament;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_listed_admins_can_use_the_panel_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config(['app.admin_emails' => ['Owner@Example.com']]);

        $owner = User::factory()->create(['email' => 'owner@example.com']);

        $this->assertTrue($owner->canAccessPanel(Filament::getPanel('admin')));
    }

    public function test_other_users_are_refused_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config(['app.admin_emails' => ['owner@example.com']]);

        $stranger = User::factory()->create(['email' => 'stranger@example.com']);

        $this->assertFalse($stranger->canAccessPanel(Filament::getPanel('admin')));
        $this->actingAs($stranger)->get('/admin')->assertForbidden();
    }

    public function test_nobody_gets_in_when_no_admin_is_configured(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config(['app.admin_emails' => []]);

        $user = User::factory()->create();

        $this->assertFalse($user->canAccessPanel(Filament::getPanel('admin')));
    }
}
