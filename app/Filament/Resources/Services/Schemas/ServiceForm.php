<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\Media;
use App\Filament\Support\Seo;
use App\Filament\Support\Translations;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->columnSpanFull()->schema([
                    Section::make('Konten')->columnSpan(2)->schema([
                        ...Translations::titleAndSlug('services'),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Ditampilkan di kartu layanan.')
                            ->rows(3),
                        RichEditor::make('body')
                            ->label('Deskripsi lengkap')
                            ->helperText('Isi halaman detail layanan (bagus untuk SEO).'),
                    ]),
                    Section::make('Tampilan')->columnSpan(1)->schema([
                        TextInput::make('icon')
                            ->label('Ikon')
                            ->helperText('Nama kelas Remix Icon, contoh: ri-code-s-slash-line'),
                        Media::image('image', 'services')->label('Gambar'),
                        Toggle::make('is_featured')->label('Tampilkan sebagai kartu unggulan'),
                        Toggle::make('is_published')->label('Tampilkan di situs')->default(true),
                    ]),
                ]),
                Seo::section('services')->columnSpanFull(),
            ]);
    }
}
