<?php

namespace App\Filament\Resources\ResumeEntries\Tables;

use App\Enums\ResumeEntryType;
use App\Models\ResumeEntry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResumeEntriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->description(fn (ResumeEntry $record): string => $record->organization)
                    ->searchable(['title', 'organization']),
                TextColumn::make('started_on')
                    ->label('Periode')
                    ->formatStateUsing(fn (ResumeEntry $record): string => $record->period()),
                ToggleColumn::make('is_published')
                    ->label('Tampil'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis')
                    ->options(ResumeEntryType::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
