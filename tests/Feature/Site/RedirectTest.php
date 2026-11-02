<?php

namespace Tests\Feature\Site;

use App\Models\Post;
use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_missing_url_follows_its_redirect_and_counts_the_hit(): void
    {
        $redirect = Redirect::factory()->create(['from_path' => '/blog/judul-lama', 'to_path' => '/blog/judul-baru']);

        $this->get('/blog/judul-lama/')->assertRedirect(url('/blog/judul-baru'))->assertStatus(301);

        $redirect->refresh();
        $this->assertSame(1, $redirect->hits);
        $this->assertNotNull($redirect->last_hit_at);
    }

    public function test_a_redirect_can_be_temporary_and_point_to_another_site(): void
    {
        Redirect::factory()->create([
            'from_path' => '/cv',
            'to_path' => 'https://example.com/cv.pdf',
            'status_code' => 302,
        ]);

        $this->get('/cv')->assertRedirect('https://example.com/cv.pdf')->assertStatus(302);
    }

    public function test_inactive_redirects_are_ignored(): void
    {
        Redirect::factory()->create(['from_path' => '/lama', 'is_active' => false]);

        $this->get('/lama')->assertNotFound();
    }

    public function test_existing_pages_are_never_redirected(): void
    {
        Post::factory()->create(['slug' => ['id' => 'masih-ada']]);
        Redirect::factory()->create(['from_path' => '/blog/masih-ada', 'to_path' => '/']);

        $this->get('/blog/masih-ada')->assertOk();
    }

    public function test_form_submissions_are_not_redirected(): void
    {
        Redirect::factory()->create(['from_path' => '/lama']);

        $this->post('/lama')->assertNotFound();
    }
}
