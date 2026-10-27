<?php

namespace App\Models;

use App\Models\Concerns\HasPublishDate;
use App\Models\Concerns\HasTranslatedSlug;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, HasPublishDate, HasTranslatedSlug, HasTranslations;

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
        'role',
        'client_name',
        'year',
        'project_url',
        'repository_url',
        'video_url',
        'cover_image',
        'gallery',
        'is_featured',
        'sort_order',
        'published_at',
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
        'role',
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
            'year' => 'integer',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsToMany<ProjectCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class);
    }
}
