<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\Seo;
use App\Filament\Support\Translations;
use App\Models\Page;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Umum')->columnSpanFull()->schema([
                    TextInput::make('title')
                        ->label('Nama halaman (menu)')
                        ->required(Translations::requiredInDefaultLocale())
                        ->maxLength(100),
                    Toggle::make('is_indexable')
                        ->label('Boleh diindeks Google')
                        ->helperText('Matikan hanya untuk halaman yang tidak ingin muncul di hasil pencarian.'),
                ]),
                Section::make('Teks di halaman')
                    ->columnSpanFull()
                    ->schema(fn (?Page $record): array => static::contentFields($record?->key)),
                Seo::section('pages')->columnSpanFull(),
            ]);
    }

    /**
     * The editable text blocks of each page, stored in the translatable
     * `content` column (e.g. `content.hero.heading`).
     *
     * @return list<Fieldset>
     */
    protected static function contentFields(?string $key): array
    {
        $blocks = match ($key) {
            'home' => [
                'Hero' => [
                    'hero.greeting' => ['Sapaan', TextInput::class],
                    'hero.heading' => ['Judul utama', Textarea::class],
                ],
                'Klien' => [
                    'clients.label' => ['Label kecil', TextInput::class],
                    'clients.heading' => ['Judul', TextInput::class],
                ],
            ],
            'about' => [
                'Perkenalan' => [
                    'intro.greeting' => ['Sapaan', TextInput::class],
                    'intro.heading' => ['Judul', TextInput::class],
                    'intro.body' => ['Isi (pisahkan paragraf dengan baris kosong)', Textarea::class],
                ],
                'Keahlian' => [
                    'skills.label' => ['Label kecil', TextInput::class],
                    'skills.heading' => ['Judul', TextInput::class],
                ],
            ],
            'services' => [
                'Layanan' => [
                    'services.label' => ['Label kecil', TextInput::class],
                    'services.heading' => ['Judul', TextInput::class],
                ],
                'Harga' => [
                    'pricing.label' => ['Label kecil', TextInput::class],
                    'pricing.heading' => ['Judul', TextInput::class],
                ],
            ],
            'works' => [
                'Header' => [
                    'header.heading' => ['Judul', TextInput::class],
                    'header.body' => ['Deskripsi', Textarea::class],
                    'header.show_all' => ['Teks filter "semua"', TextInput::class],
                ],
            ],
            'blog' => [
                'Header' => [
                    'header.heading' => ['Judul', TextInput::class],
                    'header.empty' => ['Teks saat belum ada artikel', TextInput::class],
                ],
            ],
            'contact' => [
                'Header' => [
                    'header.label' => ['Label kecil', TextInput::class],
                    'header.heading' => ['Judul', TextInput::class],
                ],
                'Formulir' => [
                    'form.name' => ['Label nama', TextInput::class],
                    'form.email' => ['Label email', TextInput::class],
                    'form.message' => ['Label pesan', TextInput::class],
                    'form.submit' => ['Teks tombol', TextInput::class],
                    'form.success' => ['Pesan berhasil terkirim', TextInput::class],
                ],
            ],
            default => [],
        };

        return array_map(
            fn (string $legend, array $fields): Fieldset => Fieldset::make($legend)->columns(1)->schema(array_map(
                /** @param  array{string, class-string<Field>}  $definition */
                fn (string $path, array $definition): Field => $definition[1]::make("content.{$path}")->label($definition[0]),
                array_keys($fields),
                $fields,
            )),
            array_keys($blocks),
            $blocks,
        );
    }
}
