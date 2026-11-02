<?php

namespace Tests\Feature\Filament;

use App\Enums\PublishStatus;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();
    }

    public function test_posts_can_be_filtered_by_publish_status(): void
    {
        $published = Post::factory()->create();
        $draft = Post::factory()->draft()->create();
        $scheduled = Post::factory()->scheduled()->create();

        Livewire::test(ListPosts::class)
            ->filterTable('status', PublishStatus::Scheduled->value)
            ->assertCanSeeTableRecords([$scheduled])
            ->assertCanNotSeeTableRecords([$published, $draft])
            ->filterTable('status', PublishStatus::Draft->value)
            ->assertCanSeeTableRecords([$draft])
            ->assertCanNotSeeTableRecords([$published, $scheduled]);
    }

    public function test_the_status_column_labels_each_post(): void
    {
        Post::factory()->create();
        Post::factory()->draft()->create();
        Post::factory()->scheduled()->create();

        Livewire::test(ListPosts::class)
            ->assertSee(['Terbit', 'Draft', 'Terjadwal']);
    }
}
