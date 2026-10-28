<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Models\ContactMessage;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengirim')->columnSpanFull()->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email')->copyable(),
                        TextEntry::make('phone')->label('Telepon')->placeholder('-')->copyable(),
                        TextEntry::make('service.title')->label('Layanan diminati')->placeholder('-'),
                        TextEntry::make('pricingPlan.name')->label('Paket diminati')->placeholder('-'),
                        TextEntry::make('created_at')->label('Dikirim')->dateTime('d M Y H:i'),
                    ]),
                ]),
                Section::make('Pesan')->columnSpanFull()->schema([
                    TextEntry::make('message')
                        ->hiddenLabel()
                        ->prose()
                        ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                        ->html(),
                ]),
                Section::make('Detail teknis')->columnSpanFull()->collapsed()->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('locale')
                            ->label('Bahasa halaman')
                            ->formatStateUsing(fn (?string $state): string => strtoupper((string) $state))
                            ->placeholder('-'),
                        TextEntry::make('ip_address')->label('IP')->placeholder('-'),
                        TextEntry::make('read_at')
                            ->label('Dibaca')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),
                    ]),
                    TextEntry::make('user_agent')
                        ->label('Browser')
                        ->placeholder('-')
                        ->visible(fn (ContactMessage $record): bool => filled($record->user_agent)),
                ]),
            ]);
    }
}
