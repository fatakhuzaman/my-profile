<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('read_at')
                    ->label('')
                    ->state(fn (ContactMessage $record): bool => $record->read_at === null)
                    ->icon(fn (bool $state): ?Heroicon => $state ? Heroicon::Envelope : Heroicon::OutlinedEnvelopeOpen)
                    ->color(fn (bool $state): string => $state ? 'primary' : 'gray')
                    ->tooltip(fn (bool $state): string => $state ? 'Belum dibaca' : 'Sudah dibaca'),
                TextColumn::make('name')
                    ->label('Nama')
                    ->description(fn (ContactMessage $record): string => $record->email)
                    ->weight(fn (ContactMessage $record): ?string => $record->read_at === null ? 'bold' : null)
                    ->searchable(['name', 'email']),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(70)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->since()
                    ->dateTimeTooltip('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')
                    ->label('Status')
                    ->nullable()
                    ->trueLabel('Sudah dibaca')
                    ->falseLabel('Belum dibaca'),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markAsRead')
                        ->label('Tandai sudah dibaca')
                        ->icon(Heroicon::OutlinedEnvelopeOpen)
                        ->action(fn (Collection $records) => $records->each->markAsRead())
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
