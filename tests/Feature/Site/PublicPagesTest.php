<?php

namespace Tests\Feature\Site;

use App\Models\Page;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(config('filesystems.media_disk'));
        $this->seed(ContentSeeder::class);
    }

    /**
     * @return array<string, array{string, string, string, string}>
     */
    public static function pages(): array
    {
        return [
            'home id' => ['/', 'id', 'Saya Fatah', 'home'],
            'home en' => ['/en', 'en', "I'm Fatah", 'home'],
            'about id' => ['/tentang', 'id', 'Saya Muhamad Nur Fatakhuzaman.', 'about'],
            'about en' => ['/en/about', 'en', "I'm Muhamad Nur Fatakhuzaman.", 'about'],
            'services id' => ['/layanan', 'id', 'Layanan Berkualitas', 'services'],
            'services en' => ['/en/services', 'en', 'Quality Services', 'services'],
            'works id' => ['/portofolio', 'id', 'Portofolio & Proyek', 'works'],
            'works en' => ['/en/works', 'en', 'Works & Projects', 'works'],
            'blog id' => ['/blog', 'id', 'Segera Hadir', 'blog'],
            'blog en' => ['/en/blog', 'en', 'Coming Soon', 'blog'],
            'contact id' => ['/kontak', 'id', 'Hubungi Saya!', 'contact'],
            'contact en' => ['/en/contact', 'en', 'Get in Touch with Me!', 'contact'],
        ];
    }

    #[DataProvider('pages')]
    public function test_every_page_renders_in_its_language(string $url, string $locale, string $expectedText, string $pageKey): void
    {
        $response = $this->get($url)->assertOk();

        $response->assertSee('<html lang="'.$locale.'">', false);
        $response->assertSee($expectedText);
        $response->assertSee('<title>'.e(Page::findByKey($pageKey)->getTranslation('meta_title', $locale)).'</title>', false);
        $this->assertSame(1, substr_count($response->getContent(), '<h1'), 'Every page needs exactly one <h1>.');
    }

    public function test_pages_link_to_their_translation(): void
    {
        $this->get('/tentang')
            ->assertSee('<link rel="canonical" href="'.url('/tentang').'">', false)
            ->assertSee('<link rel="alternate" hreflang="id" href="'.url('/tentang').'">', false)
            ->assertSee('<link rel="alternate" hreflang="en" href="'.url('/en/about').'">', false)
            ->assertSee('<link rel="alternate" hreflang="x-default" href="'.url('/tentang').'">', false);
    }

    public function test_the_share_image_is_an_absolute_url(): void
    {
        $this->get('/')->assertSee('<meta property="og:image" content="'.url('/storage/seo/profile.jpg').'">', false);
    }

    public function test_navigation_uses_the_page_titles_from_the_cms(): void
    {
        Page::findByKey('services')->setTranslation('title', 'id', 'Jasa Kami')->save();

        $this->get('/')->assertSee('Jasa Kami');
    }

    public function test_content_comes_from_the_cms(): void
    {
        Page::findByKey('home')->setTranslation('content', 'en', [
            'hero' => ['greeting' => 'Hi!', 'heading' => 'Edited from the CMS'],
        ])->save();

        $this->get('/en')->assertSee('Edited from the CMS');
    }

    public function test_pages_hidden_from_search_engines_get_noindex(): void
    {
        Page::findByKey('blog')->update(['is_indexable' => false]);

        $this->get('/blog')->assertSee('<meta name="robots" content="noindex, follow">', false);
        $this->get('/')->assertSee('<meta name="robots" content="index, follow">', false);
    }

    public function test_old_v1_urls_redirect_permanently(): void
    {
        $this->get('/about')->assertStatus(301)->assertRedirect('/tentang');
        $this->get('/services')->assertStatus(301)->assertRedirect('/layanan');
        $this->get('/works')->assertStatus(301)->assertRedirect('/portofolio');
        $this->get('/contact')->assertStatus(301)->assertRedirect('/kontak');
    }
}
