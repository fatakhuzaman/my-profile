<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use App\Models\Concerns\HasTranslatedSlug;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * A blog post category.
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static> ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static> whereSlug(string $slug, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static> translatedIn(?string $locale = null)
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, HasSortOrder, HasTranslatedSlug, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
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
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
