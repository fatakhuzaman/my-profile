<?php

namespace Tests\Feature\Database;

use App\Models\Client;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
    }

    public function test_bundled_images_and_files_are_copied_to_the_media_disk(): void
    {
        $this->seed(ContentSeeder::class);

        $disk = Storage::disk(config('filesystems.media_disk'));

        $this->assertSame('profile/profile.png', Setting::get('person.photo'));
        $disk->assertExists('profile/profile.png');
        $disk->assertExists(Setting::get('person.cv_file'));
        $disk->assertExists(Client::query()->ordered()->first()->logo);
    }

    public function test_it_seeds_every_page_in_both_locales(): void
    {
        $this->seed(ContentSeeder::class);

        foreach (['home', 'about', 'services', 'works', 'blog', 'contact'] as $key) {
            $page = Page::findByKey($key);

            $this->assertNotNull($page, "Page [{$key}] was not seeded.");
            $this->assertEqualsCanonicalizing(['id', 'en'], $page->getTranslatedLocales('meta_description'));
        }
    }

    public function test_running_it_again_does_not_overwrite_cms_edits(): void
    {
        $this->seed(ContentSeeder::class);

        Setting::query()->where('key', 'site.name')->first()->update(['value' => 'Edited in CMS']);
        $serviceCount = Service::count();

        $this->seed(ContentSeeder::class);

        $this->assertSame('Edited in CMS', Setting::get('site.name'));
        $this->assertSame($serviceCount, Service::count());
    }
}
