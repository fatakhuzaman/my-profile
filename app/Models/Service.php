<?php

namespace App\Models;

use App\Models\Concerns\HasPublishedFlag;
use App\Models\Concerns\HasSortOrder;
use App\Models\Concerns\HasTranslatedSlug;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, HasPublishedFlag, HasSortOrder, HasTranslatedSlug, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'icon',
        'image',
        'is_featured',
        'is_published',
        'sort_order',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    /**
     * The attributes that are stored per locale.
     *
     * @var list<string>
     */
    public array $translatable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return HasMany<PricingPlan, $this>
     */
    public function pricingPlans(): HasMany
    {
        return $this->hasMany(PricingPlan::class);
    }
}
