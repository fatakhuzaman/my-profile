<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\SiteSettings;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\Pages\PageResource;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\PricingPlans\PricingPlanResource;
use App\Filament\Resources\ProjectCategories\ProjectCategoryResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Redirects\RedirectResource;
use App\Filament\Resources\ResumeEntries\ResumeEntryResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Filament\Resources\Skills\SkillResource;
use App\Filament\Resources\Tags\TagResource;
use App\Filament\Resources\Testimonials\TestimonialResource;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Redirect;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Testimonial;
use Database\Seeders\ContentSeeder;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Smoke test: every CMS screen renders with real content in it.
 */
class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
        $this->actingAsAdmin();
    }

    /**
     * @return array<string, array{class-string<resource>, ?class-string<Model>}>
     */
    public static function resources(): array
    {
        return [
            'pages' => [PageResource::class, Page::class],
            'services' => [ServiceResource::class, Service::class],
            'pricing plans' => [PricingPlanResource::class, PricingPlan::class],
            'resume entries' => [ResumeEntryResource::class, ResumeEntry::class],
            'skills' => [SkillResource::class, null],
            'clients' => [ClientResource::class, null],
            'testimonials' => [TestimonialResource::class, Testimonial::class],
            'projects' => [ProjectResource::class, Project::class],
            'project categories' => [ProjectCategoryResource::class, ProjectCategory::class],
            'posts' => [PostResource::class, Post::class],
            'categories' => [CategoryResource::class, null],
            'tags' => [TagResource::class, Tag::class],
            'contact messages' => [ContactMessageResource::class, ContactMessage::class],
            'redirects' => [RedirectResource::class, Redirect::class],
        ];
    }

    /**
     * @param  class-string<resource>  $resource
     * @param  class-string<Model>|null  $model
     */
    #[DataProvider('resources')]
    public function test_every_resource_page_renders(string $resource, ?string $model): void
    {
        $record = match ($model) {
            null => null,
            Page::class => Page::findByKey('home'),
            Project::class => Project::factory()->hasAttached(ProjectCategory::factory(), [], 'categories')->create(),
            Post::class => Post::factory()->hasAttached(Tag::factory())->create(),
            default => $model::query()->first() ?? $model::factory()->create(),
        };

        $this->get($resource::getUrl('index'))->assertOk();

        foreach (['create', 'edit', 'view'] as $page) {
            if (! $resource::hasPage($page) || ($page !== 'create' && $record === null)) {
                continue;
            }

            $url = $page === 'create'
                ? $resource::getUrl('create')
                : $resource::getUrl($page, ['record' => $record]);

            $this->get($url)->assertOk();
        }
    }

    public function test_the_dashboard_and_settings_render(): void
    {
        $this->get('/admin')->assertOk();
        $this->get(SiteSettings::getUrl())->assertOk()->assertSee('Muhamad Nur Fatakhuzaman');
    }
}
