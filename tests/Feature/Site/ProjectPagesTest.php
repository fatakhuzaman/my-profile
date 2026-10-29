<?php

namespace Tests\Feature\Site;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_works_page_lists_published_projects_with_their_filters(): void
    {
        $category = ProjectCategory::factory()->create([
            'name' => ['id' => 'Aplikasi Web', 'en' => 'Web App'],
            'slug' => ['id' => 'aplikasi-web', 'en' => 'web-app'],
        ]);
        Project::factory()->hasAttached($category, [], 'categories')->create(['title' => ['id' => 'Sistem Kasir', 'en' => 'POS System']]);
        Project::factory()->draft()->create(['title' => ['id' => 'Proyek Rahasia']]);

        $this->get('/portofolio')
            ->assertOk()
            ->assertSee('Sistem Kasir')
            ->assertSee('data-filter="aplikasi-web"', false)
            ->assertSee('data-categories="aplikasi-web"', false)
            ->assertDontSee('Proyek Rahasia');

        $this->get('/en/works')->assertSee('POS System')->assertSee('data-filter="web-app"', false);
    }

    public function test_a_project_page_shows_its_details(): void
    {
        Project::factory()->create([
            'title' => ['id' => 'Sistem Kasir'],
            'slug' => ['id' => 'sistem-kasir'],
            'client_name' => 'Toko Maju',
            'year' => 2024,
            'project_url' => 'https://example.com',
        ]);

        $this->get('/portofolio/sistem-kasir')
            ->assertOk()
            ->assertSee('<h1>Sistem Kasir</h1>', false)
            ->assertSee('Toko Maju')
            ->assertSee('2024')
            ->assertSee('https://example.com');
    }

    public function test_draft_and_scheduled_projects_have_no_page(): void
    {
        Project::factory()->draft()->create(['slug' => ['id' => 'draft']]);
        Project::factory()->create(['slug' => ['id' => 'nanti'], 'published_at' => now()->addDay()]);

        $this->get('/portofolio/draft')->assertNotFound();
        $this->get('/portofolio/nanti')->assertNotFound();
    }
}
