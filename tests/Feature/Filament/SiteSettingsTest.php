<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\SiteSettings;
use App\Models\Setting;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
        $this->actingAsAdmin();
    }

    public function test_the_form_is_filled_from_the_settings_table(): void
    {
        Livewire::test(SiteSettings::class)
            ->assertSchemaStateSet([
                'site.name' => 'Fatakhuzaman',
                'contact.whatsapp' => '6288226377174',
                'person.headline.en' => 'Programmer with 4+ years of experience, formerly at PT Astra Daihatsu Motor and PT Metafora Indonesia Teknologi.',
            ]);
    }

    public function test_saving_updates_plain_and_bilingual_settings(): void
    {
        Livewire::test(SiteSettings::class)
            ->fillForm([
                'contact.phone' => '+62 811 0000 000',
                'footer.cta_heading.id' => 'Yuk mulai proyek Anda',
                'footer.cta_heading.en' => "Let's start your project",
                'person.available_for_work' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified('Pengaturan disimpan');

        $this->assertSame('+62 811 0000 000', Setting::get('contact.phone'));
        $this->assertEquals(['id' => 'Yuk mulai proyek Anda', 'en' => "Let's start your project"], Setting::get('footer.cta_heading'));
        $this->assertFalse(Setting::get('person.available_for_work'));
        $this->assertSame('Fatakhuzaman', Setting::get('site.name'));
    }

    public function test_required_fields_are_validated(): void
    {
        Livewire::test(SiteSettings::class)
            ->fillForm(['site.name' => ''])
            ->call('save')
            ->assertHasFormErrors(['site.name' => 'required']);
    }
}
