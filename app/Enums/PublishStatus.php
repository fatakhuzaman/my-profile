<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Where a record with a `published_at` date stands: a missing date is a
 * draft and a future date is scheduled.
 */
enum PublishStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Published = 'published';

    public static function fromDate(?Carbon $publishedAt): self
    {
        return match (true) {
            $publishedAt === null => self::Draft,
            $publishedAt->isFuture() => self::Scheduled,
            default => self::Published,
        };
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public function scope(Builder $query): Builder
    {
        return match ($this) {
            self::Draft => $query->whereNull('published_at'),
            self::Scheduled => $query->where('published_at', '>', now()),
            self::Published => $query->where('published_at', '<=', now()),
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Scheduled => 'Terjadwal',
            self::Published => 'Terbit',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Scheduled => 'warning',
            self::Published => 'success',
        };
    }
}
