<?php

namespace App\Filament\Resources\PricingPlans\Tables;

use App\Models\PricingPlan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PricingPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Paket')
                    ->description(fn (PricingPlan $record): ?string => $record->tagline)
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money(fn (PricingPlan $record): string => $record->currency)
                    ->placeholder('Hubungi saya'),
                IconColumn::make('is_highlighted')
                    ->label('Populer')
                    ->boolean(),
                ToggleColumn::make('is_published')
                    ->label('Tampil'),
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
