<?php

namespace App\Filament\Resources\PricingPlans\Schemas;

use App\Filament\Support\Translations;
use App\Models\Service;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->columnSpanFull()->schema([
                    Section::make('Paket')->columnSpan(2)->schema([
                        TextInput::make('name')
                            ->label('Nama paket')
                            ->required(Translations::requiredInDefaultLocale())
                            ->maxLength(100),
                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->placeholder('Paket Bisnis'),
                        Textarea::make('description')
                            ->label('Untuk siapa')
                            ->placeholder('Cocok untuk UMKM')
                            ->rows(2),
                        Repeater::make('features')
                            ->label('Daftar fitur')
                            ->simple(TextInput::make('feature')->required())
                            ->reorderable()
                            ->addActionLabel('Tambah fitur')
                            ->defaultItems(0),
                    ]),
                    Section::make('Harga')->columnSpan(1)->schema([
                        Select::make('currency')
                            ->label('Mata uang')
                            ->options(['IDR' => 'IDR (Rp)', 'USD' => 'USD ($)'])
                            ->default('IDR')
                            ->required(),
                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Kosongkan untuk menampilkan "Hubungi saya".'),
                        TextInput::make('price_suffix')
                            ->label('Keterangan harga')
                            ->placeholder('/proyek'),
                        Select::make('service_id')
                            ->label('Terkait layanan')
                            ->relationship('service', 'title')
                            ->getOptionLabelFromRecordUsing(fn (Service $record): string => $record->title)
                            ->preload(),
                        TextInput::make('cta_label')
                            ->label('Teks tombol')
                            ->placeholder('Pesan Sekarang'),
                        TextInput::make('cta_url')
                            ->label('Link tombol')
                            ->helperText('Kosongkan untuk mengarah ke halaman kontak.'),
                        Toggle::make('is_highlighted')->label('Tandai sebagai paling populer'),
                        Toggle::make('is_published')->label('Tampilkan di situs')->default(true),
                    ]),
                ]),
            ]);
    }
}
