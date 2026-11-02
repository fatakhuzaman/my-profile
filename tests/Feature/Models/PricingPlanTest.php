<?php

namespace Tests\Feature\Models;

use App\Models\PricingPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PricingPlanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{?float, string, ?string}>
     */
    public static function prices(): array
    {
        return [
            'rupiah' => [1500000, 'IDR', 'Rp 1.500.000'],
            'dollar' => [250, 'USD', '$250'],
            'no fixed price' => [null, 'USD', null],
        ];
    }

    #[DataProvider('prices')]
    public function test_it_formats_the_price_in_its_currency(?float $price, string $currency, ?string $expected): void
    {
        $plan = PricingPlan::factory()->create(['price' => $price, 'currency' => $currency]);

        $this->assertSame($expected, $plan->formatted_price);
    }
}
