<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property Carbon|null $published_at
 */
trait HasPublishDate
{
    /**
     * Only include records whose publish date has been reached.
     *
     * A null `published_at` is a draft and a future date is scheduled.
     *
     * @param  Builder<static>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Newest published records first.
     *
     * @param  Builder<static>  $query
     */
    public function scopeLatestPublished(Builder $query): void
    {
        $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }
}
