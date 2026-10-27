<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexable',
    ];

    /**
     * The attributes that are stored per locale.
     *
     * @var list<string>
     */
    public array $translatable = [
        'title',
        'content',
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
            'is_indexable' => 'boolean',
        ];
    }

    /**
     * Find a page by its fixed key (home, about, services, ...).
     */
    public static function findByKey(string $key): ?self
    {
        return static::query()->where('key', $key)->first();
    }

    /**
     * Read a single text from the page's translated content blocks,
     * e.g. `$page->section('hero.heading')`.
     */
    public function section(string $path, mixed $default = null): mixed
    {
        return data_get($this->content, $path, $default);
    }
}
