<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use App\Models\Concerns\HasTranslatedSlug;
use Database\Factories\ProjectCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static> ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static> whereSlug(string $slug, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static> translatedIn(?string $locale = null)
 */
class ProjectCategory extends Model
{
    /** @use HasFactory<ProjectCategoryFactory> */
    use HasFactory, HasSortOrder, HasTranslatedSlug, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    /**
     * The attributes that are stored per locale.
     *
     * @var list<string>
     */
    public array $translatable = [
        'name',
        'slug',
    ];

    /**
     * @return BelongsToMany<Project, $this>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
