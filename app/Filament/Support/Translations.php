<?php

namespace App\Filament\Support;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

/**
 * Form helpers for models edited one locale at a time through the
 * LaraZeus locale switcher.
 */
class Translations
{
    public static function defaultLocale(): string
    {
        return config('app.supported_locales')[0];
    }

    /**
     * The locale currently selected in the form's locale switcher.
     */
    public static function activeLocale(mixed $livewire): string
    {
        return $livewire->activeLocale ?? static::defaultLocale();
    }

    /**
     * Fields are only required in the default locale; leaving the other
     * locale blank means "not translated yet".
     */
    public static function requiredInDefaultLocale(): Closure
    {
        return fn (mixed $livewire): bool => static::activeLocale($livewire) === static::defaultLocale();
    }

    /**
     * A title input that fills in the slug while the slug is still empty,
     * followed by the slug input itself.
     *
     * @return array{TextInput, TextInput}
     */
    public static function titleAndSlug(string $table, string $titleField = 'title', string $titleLabel = 'Judul'): array
    {
        return [
            TextInput::make($titleField)
                ->label($titleLabel)
                ->required(static::requiredInDefaultLocale())
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                    if (blank($get('slug')) && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),
            TextInput::make('slug')
                ->label('Slug (URL)')
                ->helperText('Bagian alamat halaman, contoh: jasa-pembuatan-website. Kosongkan bahasa yang belum diterjemahkan.')
                ->required(static::requiredInDefaultLocale())
                ->maxLength(255)
                ->alphaDash()
                ->rule(fn (mixed $livewire, ?Model $record): Unique => Rule::unique($table, 'slug->'.static::activeLocale($livewire))
                    ->ignore($record?->getKey())),
        ];
    }
}
