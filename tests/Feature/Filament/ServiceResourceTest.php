<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();
    }

    public function test_the_list_page_shows_services(): void
    {
        $services = Service::factory()->count(2)->create();

        Livewire::test(ListServices::class)
            ->assertOk()
            ->assertCanSeeTableRecords($services);
    }

    public function test_a_service_can_be_created_in_indonesian_only(): void
    {
        Livewire::test(CreateService::class)
            ->fillForm([
                'title' => 'Pembuatan Website',
                'slug' => 'pembuatan-website',
                'excerpt' => 'Website cepat dan ramah SEO.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $service = Service::sole();

        $this->assertSame('Pembuatan Website', $service->getTranslation('title', 'id'));
        $this->assertSame(['id'], $service->getTranslatedLocales('slug'));
    }

    public function test_the_english_translation_is_saved_separately(): void
    {
        $service = Service::factory()->create([
            'title' => ['id' => 'Konsultan IT'],
            'slug' => ['id' => 'konsultan-it'],
        ]);

        Livewire::test(EditService::class, ['record' => $service->getRouteKey()])
            ->set('activeLocale', 'en')
            ->fillForm([
                'title' => 'IT Consultant',
                'slug' => 'it-consultant',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $service->refresh();

        $this->assertSame('Konsultan IT', $service->getTranslation('title', 'id'));
        $this->assertSame('IT Consultant', $service->getTranslation('title', 'en'));
        $this->assertSame('it-consultant', $service->getTranslation('slug', 'en'));
    }

    public function test_the_slug_must_be_unique_within_a_locale(): void
    {
        Service::factory()->create(['slug' => ['id' => 'software-erp', 'en' => 'erp-software']]);

        Livewire::test(CreateService::class)
            ->fillForm([
                'title' => 'Software ERP',
                'slug' => 'software-erp',
            ])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'unique']);
    }
}
