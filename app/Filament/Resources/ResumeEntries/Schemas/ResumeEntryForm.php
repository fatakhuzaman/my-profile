<?php

namespace App\Filament\Resources\ResumeEntries\Schemas;

use App\Enums\ResumeEntryType;
use App\Filament\Support\Media;
use App\Filament\Support\Translations;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ResumeEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->columnSpanFull()->schema([
                    Grid::make(2)->schema([
                        Select::make('type')
                            ->label('Jenis')
                            ->options(ResumeEntryType::class)
                            ->required(),
                        TextInput::make('title')
                            ->label('Jabatan / jurusan / nama prestasi')
                            ->required(Translations::requiredInDefaultLocale())
                            ->maxLength(255),
                        TextInput::make('organization')
                            ->label('Perusahaan / institusi / penyelenggara')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Lokasi'),
                    ]),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(3),
                    Grid::make(3)->schema([
                        DatePicker::make('started_on')
                            ->label('Mulai')
                            ->required(),
                        DatePicker::make('ended_on')
                            ->label('Selesai')
                            ->helperText('Kosongkan jika masih berjalan.')
                            ->afterOrEqual('started_on'),
                        Select::make('date_precision')
                            ->label('Format tanggal')
                            ->options([
                                'year' => 'Tahun (2023 - 2025)',
                                'month' => 'Bulan & tahun (Jun - Aug 2019)',
                            ])
                            ->default('year')
                            ->required(),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('url')
                            ->label('Website')
                            ->url(),
                        Media::image('logo', 'resume')->label('Logo'),
                    ]),
                    Toggle::make('is_published')->label('Tampilkan di situs')->default(true),
                ]),
            ]);
    }
}
