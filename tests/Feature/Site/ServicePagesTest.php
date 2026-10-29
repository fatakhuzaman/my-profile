<?php

namespace Tests\Feature\Site;

use App\Models\PricingPlan;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_service_has_a_page_in_each_translated_locale(): void
    {
        Service::factory()->create([
            'title' => ['id' => 'Pembuatan Website', 'en' => 'Web Development'],
            'slug' => ['id' => 'pembuatan-website', 'en' => 'web-development'],
            'body' => ['id' => '<p>Website cepat untuk UMKM.</p>', 'en' => '<p>Fast websites for SMEs.</p>'],
        ]);

        $this->get('/layanan/pembuatan-website')
            ->assertOk()
            ->assertSee('<h1>Pembuatan Website</h1>', false)
            ->assertSee('Website cepat untuk UMKM.')
            ->assertSee('<link rel="alternate" hreflang="en" href="'.url('/en/services/web-development').'">', false);

        $this->get('/en/services/web-development')
            ->assertOk()
            ->assertSee('Fast websites for SMEs.');
    }

    public function test_a_slug_only_works_in_its_own_locale(): void
    {
        Service::factory()->create(['slug' => ['id' => 'konsultan-it', 'en' => 'it-consultant']]);

        $this->get('/en/services/konsultan-it')->assertNotFound();
        $this->get('/layanan/it-consultant')->assertNotFound();
    }

    public function test_untranslated_and_hidden_services_have_no_page(): void
    {
        Service::factory()->create(['slug' => ['id' => 'hanya-indonesia']]);
        Service::factory()->unpublished()->create(['slug' => ['id' => 'disembunyikan', 'en' => 'hidden']]);

        $this->get('/layanan/hanya-indonesia')->assertOk();
        $this->get('/en/services/hanya-indonesia')->assertNotFound();
        $this->get('/layanan/disembunyikan')->assertNotFound();
    }

    public function test_the_service_page_lists_its_pricing_plans(): void
    {
        $service = Service::factory()->create(['slug' => ['id' => 'erp']]);
        PricingPlan::factory()->for($service)->create([
            'name' => ['id' => 'Paket ERP'],
            'price' => 7500000,
            'currency' => 'IDR',
        ]);

        $this->get('/layanan/erp')
            ->assertSee('Paket ERP')
            ->assertSee('Rp 7.500.000');
    }

    public function test_rich_content_is_sanitized(): void
    {
        Service::factory()->create([
            'slug' => ['id' => 'aman'],
            'body' => ['id' => '<p>Halo</p><script>alert("xss")</script>'],
        ]);

        $this->get('/layanan/aman')
            ->assertSee('Halo')
            ->assertDontSee('alert("xss")', false);
    }
}
