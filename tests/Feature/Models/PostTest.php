<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_excludes_drafts_and_scheduled_posts(): void
    {
        $published = Post::factory()->create();
        Post::factory()->draft()->create();
        Post::factory()->scheduled()->create();

        $this->assertEquals([$published->id], Post::published()->pluck('id')->all());
    }

    public function test_it_finds_a_post_by_the_slug_of_a_given_locale(): void
    {
        $post = Post::factory()->create([
            'slug' => ['id' => 'cara-membuat-website', 'en' => 'how-to-build-a-website'],
        ]);

        $this->assertTrue(Post::whereSlug('cara-membuat-website', 'id')->first()->is($post));
        $this->assertTrue(Post::whereSlug('how-to-build-a-website', 'en')->first()->is($post));
        $this->assertNull(Post::whereSlug('how-to-build-a-website', 'id')->first());
    }

    public function test_slug_lookup_defaults_to_the_current_locale(): void
    {
        $post = Post::factory()->create([
            'slug' => ['id' => 'tips-seo', 'en' => 'seo-tips'],
        ]);

        app()->setLocale('en');

        $this->assertTrue(Post::whereSlug('seo-tips')->first()->is($post));
    }

    public function test_untranslated_posts_are_excluded_from_that_locale(): void
    {
        $bilingual = Post::factory()->create();
        $indonesianOnly = Post::factory()->indonesianOnly()->create();

        $this->assertEqualsCanonicalizing(
            [$bilingual->id, $indonesianOnly->id],
            Post::translatedIn('id')->pluck('id')->all(),
        );
        $this->assertEquals([$bilingual->id], Post::translatedIn('en')->pluck('id')->all());
    }

    public function test_missing_translations_fall_back_to_indonesian(): void
    {
        $post = Post::factory()->indonesianOnly()->create(['title' => ['id' => 'Judul Artikel']]);

        app()->setLocale('en');

        $this->assertSame('Judul Artikel', $post->title);
    }

    public function test_slugs_must_be_unique_per_locale(): void
    {
        Post::factory()->create(['slug' => ['id' => 'judul-sama', 'en' => 'first-title']]);

        $this->expectException(UniqueConstraintViolationException::class);

        Post::factory()->create(['slug' => ['id' => 'judul-sama', 'en' => 'second-title']]);
    }

    public function test_the_same_slug_may_be_used_in_different_locales(): void
    {
        Post::factory()->create(['slug' => ['id' => 'laravel', 'en' => 'laravel-id']]);
        Post::factory()->create(['slug' => ['id' => 'laravel-en', 'en' => 'laravel']]);

        $this->assertSame(2, Post::count());
    }

    public function test_blank_translations_are_not_stored(): void
    {
        $first = Post::factory()->create(['slug' => ['id' => 'pertama', 'en' => '']]);
        $second = Post::factory()->create(['slug' => ['id' => 'kedua', 'en' => null]]);

        $this->assertSame(['id'], $first->fresh()->getTranslatedLocales('slug'));
        $this->assertSame(['id'], $second->fresh()->getTranslatedLocales('slug'));
        $this->assertSame(0, Post::translatedIn('en')->count());
    }

    public function test_reading_time_is_at_least_one_minute(): void
    {
        $post = Post::factory()->create(['body' => ['id' => 'Singkat saja.', 'en' => str_repeat('word ', 450)]]);

        $this->assertSame(1, $post->readingTime('id'));
        $this->assertSame(3, $post->readingTime('en'));
    }
}
