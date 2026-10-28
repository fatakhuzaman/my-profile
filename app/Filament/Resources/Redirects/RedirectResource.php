<?php

namespace App\Filament\Resources\Redirects;

use App\Filament\Resources\Redirects\Pages\ManageRedirects;
use App\Models\Redirect;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUturnRight;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $modelLabel = 'redirect';

    protected static ?string $pluralModelLabel = 'redirect';

    protected static ?string $navigationLabel = 'Redirect URL';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'from_path';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('from_path')
                    ->label('Dari URL')
                    ->placeholder('/blog/judul-lama')
                    ->helperText('Path lama, diawali "/".')
                    ->required()
                    ->startsWith('/')
                    ->unique(ignoreRecord: true),
                TextInput::make('to_path')
                    ->label('Ke URL')
                    ->placeholder('/blog/judul-baru')
                    ->helperText('Path baru atau URL lengkap.')
                    ->required(),
                Select::make('status_code')
                    ->label('Jenis')
                    ->options([
                        301 => '301 – Permanen (disarankan untuk SEO)',
                        302 => '302 – Sementara',
                    ])
                    ->default(301)
                    ->required(),
                Toggle::make('is_active')->label('Aktif')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('from_path')
                    ->label('Dari')
                    ->searchable(),
                TextColumn::make('to_path')
                    ->label('Ke')
                    ->searchable(),
                TextColumn::make('status_code')
                    ->label('Kode')
                    ->badge(),
                TextColumn::make('hits')
                    ->label('Dipakai')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_hit_at')
                    ->label('Terakhir')
                    ->since()
                    ->placeholder('-'),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRedirects::route('/'),
        ];
    }
}
