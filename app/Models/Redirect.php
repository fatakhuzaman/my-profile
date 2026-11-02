<?php

namespace App\Models;

use Database\Factories\RedirectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A manual redirect, used to keep old URLs (e.g. after a slug change)
 * pointing at their new location so search rankings are preserved.
 *
 * @mixin IdeHelperRedirect
 */
class Redirect extends Model
{
    /** @use HasFactory<RedirectFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'from_path',
        'to_path',
        'status_code',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'is_active' => 'boolean',
            'hits' => 'integer',
            'last_hit_at' => 'datetime',
        ];
    }

    /**
     * The active redirect for a request path, with or without a trailing slash.
     */
    public static function findForPath(string $path): ?self
    {
        $path = '/'.trim(rawurldecode($path), '/');

        return static::query()
            ->where('is_active', true)
            ->whereIn('from_path', [$path, $path.'/'])
            ->first();
    }

    /**
     * The absolute URL to send visitors to; `to_path` may be a path on this
     * site or a full URL elsewhere.
     */
    public function targetUrl(): string
    {
        return str_starts_with($this->to_path, '/') ? url($this->to_path) : $this->to_path;
    }

    public function recordHit(): void
    {
        static::query()->whereKey($this->getKey())->increment('hits', 1, ['last_hit_at' => now()]);
    }
}
