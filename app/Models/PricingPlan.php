<?php

namespace App\Models;

use App\Models\Concerns\HasPublishedFlag;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\PricingPlanFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;
use Spatie\Translatable\HasTranslations;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static> published()
 * @method static \Illuminate\Database\Eloquent\Builder<static> ordered()
 *
 * @mixin IdeHelperPricingPlan
 */
class PricingPlan extends Model
{
    /** @use HasFactory<PricingPlanFactory> */
    use HasFactory, HasPublishedFlag, HasSortOrder, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'service_id',
        'name',
        'tagline',
        'description',
        'price',
        'currency',
        'price_suffix',
        'features',
        'cta_label',
        'cta_url',
        'is_highlighted',
        'is_published',
        'sort_order',
    ];

    /**
     * The attributes that are stored per locale. `features` holds a list
     * of feature lines per locale.
     *
     * @var list<string>
     */
    public array $translatable = [
        'name',
        'tagline',
        'description',
        'price_suffix',
        'features',
        'cta_label',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_highlighted' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * The price as shown to visitors, e.g. "Rp 1.500.000" or "$250", or
     * null when the plan has no fixed price.
     *
     * @return Attribute<?string, never>
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn (): ?string => match (true) {
            $this->price === null => null,
            $this->currency === 'IDR' => 'Rp '.number_format((float) $this->price, 0, ',', '.'),
            default => Number::currency((float) $this->price, in: $this->currency, locale: 'en', precision: 0),
        });
    }
}
