<?php

namespace Tests\Feature\Database;

use App\Models\Post;
use App\Models\Project;
use Database\Seeders\ContentSeeder;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DemoContentSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
    }

    public function test_it_seeds_three_projects_and_seven_posts_in_both_languages(): void
    {
        $this->seed(DemoContentSeeder::class);

        $this->assertSame(3, Project::published()->translatedIn('en')->count());
        $this->assertSame(7, Post::published()->translatedIn('en')->count());
        Storage::disk(config('filesystems.media_disk'))->assertExists(Project::query()->first()->cover_image);
    }

    public function test_running_it_twice_does_not_duplicate_anything(): void
    {
        $this->seed(DemoContentSeeder::class);
        $this->seed(DemoContentSeeder::class);

        $this->assertSame(3, Project::count());
        $this->assertSame(7, Post::count());
    }

    public function test_the_demo_content_renders_on_the_site(): void
    {
        $this->seed(DemoContentSeeder::class);

        $this->get('/')->assertOk()->assertSee('Sistem Kasir &amp; Inventaris Toko Retail', false);
        $this->get('/portofolio')->assertOk()->assertSee('Dashboard Monitoring Produksi');
        $this->get('/portofolio/sistem-kasir-inventaris-toko-retail')->assertOk();
        $this->get('/en/works/retail-pos-inventory-system')->assertOk();
        $this->get('/blog')->assertOk()->assertSee('Berapa Biaya Pembuatan Website untuk UMKM di 2026?');
        $this->get('/blog/5-tanda-bisnis-anda-sudah-butuh-sistem-erp')->assertOk();
        $this->get('/en/blog/5-signs-your-business-needs-an-erp-system')->assertOk();
    }

    public function test_it_is_not_part_of_the_default_seeder(): void
    {
        $this->seed();

        $this->assertSame(0, Project::count());
        $this->assertSame(0, Post::count());
    }
}
