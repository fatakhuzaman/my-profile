<?php

namespace App\Models;

use App\Models\Concerns\HasPublishedFlag;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\PricingPlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

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
}
