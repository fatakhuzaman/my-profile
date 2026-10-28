<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

/**
 * The search engine fields shared by every public page type.
 */
class Seo
{
    public static function section(string $imageDirectory): Section
    {
        return Section::make('SEO')
            ->description('Judul & deskripsi yang tampil di Google dan saat dibagikan ke media sosial. Kosongkan untuk memakai judul/ringkasan.')
            ->collapsible()
            ->collapsed()
            ->schema([
                TextInput::make('meta_title')
                    ->label('Meta title')
                    ->maxLength(70)
                    ->helperText('Idealnya 50–60 karakter.'),
                Textarea::make('meta_description')
                    ->label('Meta description')
                    ->rows(3)
                    ->maxLength(170)
                    ->helperText('Idealnya 140–160 karakter.'),
                Media::image('og_image', $imageDirectory.'/og')
                    ->label('Gambar saat dibagikan (Open Graph)')
                    ->helperText('Rekomendasi 1200×630 px.'),
            ]);
    }
}
