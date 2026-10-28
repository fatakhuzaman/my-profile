<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Filament\Support\PublishStatus;
use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('')
                    ->disk(config('filesystems.media_disk'))
                    ->imageHeight(40),
                TextColumn::make('title')
                    ->label('Judul')
                    ->description(fn (Project $record): ?string => $record->client_name)
                    ->searchable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                PublishStatus::column(),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
            ])
            ->filters([
                PublishStatus::filter(),
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
