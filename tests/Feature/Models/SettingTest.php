<?php

namespace Tests\Feature\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_stored_value_or_the_default(): void
    {
        Setting::create(['key' => 'contact.email', 'value' => 'hello@example.com']);
        Setting::create(['key' => 'person.available_for_work', 'value' => true]);

        $this->assertSame('hello@example.com', Setting::get('contact.email'));
        $this->assertTrue(Setting::get('person.available_for_work'));
        $this->assertSame('fallback', Setting::get('missing.key', 'fallback'));
    }

    public function test_localized_values_follow_the_current_locale(): void
    {
        Setting::create(['key' => 'footer.cta_heading', 'value' => ['id' => 'Halo', 'en' => 'Hello']]);
        Setting::create(['key' => 'only.indonesian', 'value' => ['id' => 'Hanya Indonesia']]);

        $this->assertSame('Halo', Setting::localized('footer.cta_heading'));
        $this->assertSame('Hello', Setting::localized('footer.cta_heading', 'en'));
        $this->assertSame('Hanya Indonesia', Setting::localized('only.indonesian', 'en'));
    }

    public function test_the_cache_is_refreshed_when_a_setting_changes(): void
    {
        $setting = Setting::create(['key' => 'site.name', 'value' => 'Old Name']);
        $this->assertSame('Old Name', Setting::get('site.name'));

        $setting->update(['value' => 'New Name']);
        $this->assertSame('New Name', Setting::get('site.name'));

        $setting->delete();
        $this->assertNull(Setting::get('site.name'));
    }
}
