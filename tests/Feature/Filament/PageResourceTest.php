<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Page;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PageResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
        $this->actingAsAdmin();
    }

    public function test_the_form_shows_the_content_of_the_active_locale(): void
    {
        $home = Page::findByKey('home');

        Livewire::test(EditPage::class, ['record' => $home->getRouteKey()])
            ->assertSchemaStateSet(['content.hero.greeting' => 'Halo!'])
            ->set('activeLocale', 'en')
            ->assertSchemaStateSet(['content.hero.greeting' => 'Hello There!']);
    }

    public function test_editing_one_locale_keeps_the_other(): void
    {
        $home = Page::findByKey('home');

        Livewire::test(EditPage::class, ['record' => $home->getRouteKey()])
            ->set('activeLocale', 'en')
            ->fillForm(['content.hero.heading' => 'I build fast, SEO friendly websites.'])
            ->call('save')
            ->assertHasNoFormErrors();

        $home->refresh();

        $this->assertSame('I build fast, SEO friendly websites.', $home->getTranslation('content', 'en')['hero']['heading']);
        $this->assertSame('Hello There!', $home->getTranslation('content', 'en')['hero']['greeting']);
        $this->assertStringStartsWith('Saya Fatah', $home->getTranslation('content', 'id')['hero']['heading']);
    }

    public function test_pages_cannot_be_created_or_deleted(): void
    {
        $this->get('/admin/pages/create')->assertNotFound();

        Livewire::test(EditPage::class, ['record' => Page::findByKey('about')->getRouteKey()])
            ->assertActionDoesNotExist('delete');
    }
}
