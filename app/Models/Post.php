<?php

namespace App\Models;

use App\Models\Concerns\HasPublishDate;
use App\Models\Concerns\HasTranslatedSlug;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, HasPublishDate, HasTranslatedSlug, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'is_featured',
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
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Estimated reading time in minutes for the given locale.
     */
    public function readingTime(?string $locale = null): int
    {
        $words = str_word_count(strip_tags((string) $this->getTranslation('body', $locale ?? app()->getLocale())));

        return max(1, (int) ceil($words / 200));
    }
}
