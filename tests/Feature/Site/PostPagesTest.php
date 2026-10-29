<?php

namespace Tests\Feature\Site;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_blog_lists_published_posts_of_the_current_language(): void
    {
        Post::factory()->create(['title' => ['id' => 'Tips SEO untuk UMKM', 'en' => 'SEO tips for SMEs']]);
        Post::factory()->indonesianOnly()->create(['title' => ['id' => 'Hanya bahasa Indonesia']]);
        Post::factory()->draft()->create(['title' => ['id' => 'Masih draft', 'en' => 'Still a draft']]);
        Post::factory()->scheduled()->create(['title' => ['id' => 'Terjadwal', 'en' => 'Scheduled']]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Tips SEO untuk UMKM')
            ->assertSee('Hanya bahasa Indonesia')
            ->assertDontSee('Masih draft')
            ->assertDontSee('Terjadwal');

        $this->get('/en/blog')
            ->assertOk()
            ->assertSee('SEO tips for SMEs')
            ->assertDontSee('Hanya bahasa Indonesia')
            ->assertDontSee('Still a draft');
    }

    public function test_a_post_page_shows_the_article(): void
    {
        $post = Post::factory()->create([
            'title' => ['id' => 'Cara Memilih Jasa Website'],
            'slug' => ['id' => 'cara-memilih-jasa-website'],
            'body' => ['id' => '<h2>Langkah pertama</h2><p>Tentukan kebutuhan.</p>'],
        ]);

        $this->get('/blog/cara-memilih-jasa-website')
            ->assertOk()
            ->assertSee('<h1>Cara Memilih Jasa Website</h1>', false)
            ->assertSee('<h2>Langkah pertama</h2>', false)
            ->assertSee($post->author->name)
            ->assertSee('menit baca');
    }

    public function test_unpublished_or_untranslated_posts_have_no_page(): void
    {
        Post::factory()->draft()->create(['slug' => ['id' => 'draft', 'en' => 'draft']]);
        Post::factory()->indonesianOnly()->create(['slug' => ['id' => 'khusus-indonesia']]);

        $this->get('/blog/draft')->assertNotFound();
        $this->get('/blog/khusus-indonesia')->assertOk();
        $this->get('/en/blog/khusus-indonesia')->assertNotFound();
    }

    public function test_the_language_switcher_falls_back_to_the_home_page_for_untranslated_posts(): void
    {
        Post::factory()->indonesianOnly()->create(['slug' => ['id' => 'khusus-indonesia']]);

        $this->get('/blog/khusus-indonesia')
            ->assertSee('href="'.url('/en').'"', false)
            ->assertDontSee('hreflang="en" href="'.url('/en/blog'), false);
    }
}
