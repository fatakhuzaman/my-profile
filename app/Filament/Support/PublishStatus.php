<?php

namespace App\Filament\Support;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Draft / scheduled / published status for models with a `published_at`.
 */
class PublishStatus
{
    public const DRAFT = 'draft';

    public const SCHEDULED = 'scheduled';

    public const PUBLISHED = 'published';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::DRAFT => 'Draft',
            self::SCHEDULED => 'Terjadwal',
            self::PUBLISHED => 'Terbit',
        ];
    }

    public static function of(Model $record): string
    {
        return match (true) {
            $record->published_at === null => self::DRAFT,
            $record->published_at->isFuture() => self::SCHEDULED,
            default => self::PUBLISHED,
        };
    }

    public static function column(): TextColumn
    {
        return TextColumn::make('published_at')
            ->label('Status')
            ->badge()
            ->state(fn (Model $record): string => static::of($record))
            ->formatStateUsing(fn (string $state): string => static::options()[$state])
            ->color(fn (string $state): string => match ($state) {
                self::DRAFT => 'gray',
                self::SCHEDULED => 'warning',
                self::PUBLISHED => 'success',
            })
            ->description(fn (Model $record): ?string => $record->published_at?->translatedFormat('d M Y H:i'))
            ->sortable();
    }

    public static function filter(): SelectFilter
    {
        return SelectFilter::make('status')
            ->label('Status')
            ->options(static::options())
            ->query(fn (Builder $query, array $data): Builder => match ($data['value'] ?? null) {
                self::DRAFT => $query->whereNull('published_at'),
                self::SCHEDULED => $query->where('published_at', '>', now()),
                self::PUBLISHED => $query->where('published_at', '<=', now()),
                default => $query,
            });
    }
}
