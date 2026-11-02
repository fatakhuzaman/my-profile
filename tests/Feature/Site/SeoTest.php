<?php

namespace Tests\Feature\Site;

use App\Models\Page;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_sitemap_lists_every_page_in_both_languages(): void
    {
        $post = Post::factory()->create(['slug' => ['id' => 'tips-seo', 'en' => 'seo-tips']]);
        Post::factory()->indonesianOnly()->create(['slug' => ['id' => 'khusus-indonesia']]);
        Post::factory()->draft()->create(['slug' => ['id' => 'masih-draft', 'en' => 'still-a-draft']]);

        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string($response->getContent());
        $locations = array_map('strval', $xml->xpath('//*[local-name()="loc"]'));

        $this->assertContains(url('/'), $locations);
        $this->assertContains(url('/en'), $locations);
        $this->assertContains(url('/tentang'), $locations);
        $this->assertContains(url('/en/about'), $locations);
        $this->assertContains(url('/blog/tips-seo'), $locations);
        $this->assertContains(url('/en/blog/seo-tips'), $locations);
        $this->assertContains(url('/blog/khusus-indonesia'), $locations);
        $this->assertNotContains(url('/en/blog/khusus-indonesia'), $locations);
        $this->assertNotContains(url('/blog/masih-draft'), $locations);

        $response->assertSee('<lastmod>'.$post->updated_at->toAtomString().'</lastmod>', false)
            ->assertSee('<xhtml:link rel="alternate" hreflang="en" href="'.url('/en/blog/seo-tips').'" />', false);
    }

    public function test_the_sitemap_skips_pages_hidden_from_search_engines(): void
    {
        Page::factory()->create(['key' => 'contact', 'is_indexable' => false]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertDontSee('<loc>'.url('/kontak').'</loc>', false)
            ->assertSee('<loc>'.url('/tentang').'</loc>', false);
    }

    public function test_robots_txt_blocks_everything_outside_production(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee("User-agent: *\nDisallow: /\n", false);
    }

    public function test_robots_txt_points_crawlers_to_the_sitemap_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.url('/sitemap.xml'))
            ->assertDontSee("Disallow: /\n", false);
    }

    public function test_every_page_describes_the_site_owner(): void
    {
        $graph = $this->jsonLd($this->get('/'));

        $this->assertSame(['WebSite', 'Person'], Arr::pluck($graph, '@type'));
        $this->assertSame(url('/').'#person', $graph[1]['@id']);
    }

    public function test_a_post_page_describes_the_article_and_its_breadcrumbs(): void
    {
        $post = Post::factory()->create([
            'title' => ['id' => 'Cara Memilih Jasa Website'],
            'slug' => ['id' => 'cara-memilih-jasa-website'],
        ]);

        $graph = $this->jsonLd($this->get('/blog/cara-memilih-jasa-website'));
        $article = collect($graph)->firstWhere('@type', 'BlogPosting');
        $breadcrumbs = collect($graph)->firstWhere('@type', 'BreadcrumbList');

        $this->assertSame('Cara Memilih Jasa Website', $article['headline']);
        $this->assertSame(url('/blog/cara-memilih-jasa-website'), $article['mainEntityOfPage']);
        $this->assertSame($post->published_at->toIso8601String(), $article['datePublished']);
        $this->assertSame($post->author->name, $article['author']['name']);
        $this->assertSame(
            [url('/'), url('/blog'), url('/blog/cara-memilih-jasa-website')],
            Arr::pluck($breadcrumbs['itemListElement'], 'item'),
        );
    }

    public function test_a_service_page_lists_its_pricing_plans_as_offers(): void
    {
        $service = Service::factory()->create(['slug' => ['id' => 'pembuatan-website', 'en' => 'web-development']]);
        PricingPlan::factory()->for($service)->create(['price' => 250, 'currency' => 'USD']);

        $graph = $this->jsonLd($this->get('/en/services/web-development'));
        $offers = collect($graph)->firstWhere('@type', 'Service')['offers'];

        $this->assertSame([['USD', '250.00']], array_map(
            fn (array $offer): array => [$offer['priceCurrency'], $offer['price']],
            $offers,
        ));
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function jsonLd(TestResponse $response): array
    {
        $response->assertOk();

        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $response->getContent(), $matches);

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR)['@graph'];
    }
}
