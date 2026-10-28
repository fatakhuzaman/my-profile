<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\PricingPlans\Pages\CreatePricingPlan;
use App\Filament\Resources\PricingPlans\Pages\EditPricingPlan;
use App\Models\PricingPlan;
use Filament\Forms\Components\Repeater;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PricingPlanResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();
    }

    public function test_a_plan_is_created_with_its_feature_list(): void
    {
        $undoRepeaterFake = Repeater::fake();

        Livewire::test(CreatePricingPlan::class)
            ->fillForm([
                'name' => 'Starter',
                'currency' => 'IDR',
                'price' => 1500000,
                'features' => [['feature' => 'Landing page'], ['feature' => 'Gratis domain 1 tahun']],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $undoRepeaterFake();

        $plan = PricingPlan::sole();

        $this->assertSame(['Landing page', 'Gratis domain 1 tahun'], $plan->getTranslation('features', 'id'));
        $this->assertSame('IDR', $plan->currency);
        $this->assertSame('1500000.00', $plan->price);
    }

    public function test_english_features_are_saved_without_touching_indonesian(): void
    {
        $plan = PricingPlan::factory()->create([
            'features' => ['id' => ['Konsultasi 3 jam'], 'en' => ['3 hours consultation']],
        ]);

        $undoRepeaterFake = Repeater::fake();

        Livewire::test(EditPricingPlan::class, ['record' => $plan->getRouteKey()])
            ->assertSchemaStateSet(['features' => [['feature' => 'Konsultasi 3 jam']]])
            ->set('activeLocale', 'en')
            ->assertSchemaStateSet(['features' => [['feature' => '3 hours consultation']]])
            ->fillForm(['features' => [['feature' => '3 hours consultation'], ['feature' => 'Priority support']]])
            ->call('save')
            ->assertHasNoFormErrors();

        $undoRepeaterFake();

        $plan->refresh();

        $this->assertSame(['Konsultasi 3 jam'], $plan->getTranslation('features', 'id'));
        $this->assertSame(['3 hours consultation', 'Priority support'], $plan->getTranslation('features', 'en'));
    }
}
