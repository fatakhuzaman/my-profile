<?php

namespace App\Filament\Support;

use App\Enums\PublishStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Table column and filter for models with a `published_at` date.
 */
class PublishStatusTable
{
    public static function column(): TextColumn
    {
        return TextColumn::make('published_at')
            ->label('Status')
            ->badge()
            ->state(fn (Model $record): PublishStatus => PublishStatus::fromDate($record->published_at))
            ->description(fn (Model $record): ?string => $record->published_at?->translatedFormat('d M Y H:i'))
            ->sortable();
    }

    public static function filter(): SelectFilter
    {
        return SelectFilter::make('status')
            ->label('Status')
            ->options(PublishStatus::class)
            ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                ? PublishStatus::from($data['value'])->scope($query)
                : $query);
    }
}
