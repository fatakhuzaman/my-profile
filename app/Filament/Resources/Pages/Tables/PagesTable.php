<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id')
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Halaman'),
                TextColumn::make('key')
                    ->label('Kode')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('meta_title')
                    ->label('Meta title')
                    ->placeholder('-')
                    ->limit(50),
                IconColumn::make('is_indexable')
                    ->label('Diindeks')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
