<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    public const CACHE_KEY = 'settings.all';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::allCached()[$key] ?? $default;
    }

    /**
     * Get a translatable setting (stored as `['id' => ..., 'en' => ...]`)
     * in the given locale, falling back to the fallback locale.
     */
    public static function localized(string $key, ?string $locale = null, mixed $default = null): mixed
    {
        $value = static::get($key);

        if (! is_array($value)) {
            return $value ?? $default;
        }

        $locale ??= app()->getLocale();

        return $value[$locale] ?? $value[config('app.supported_locales')[0]] ?? $default;
    }

    /**
     * All settings keyed by name, cached until a setting changes.
     *
     * @return array<string, mixed>
     */
    public static function allCached(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            fn (): array => static::query()->pluck('value', 'key')->all(),
        );
    }
}
