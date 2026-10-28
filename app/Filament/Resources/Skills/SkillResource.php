<?php

namespace App\Filament\Resources\Skills;

use App\Filament\Resources\Skills\Pages\ManageSkills;
use App\Filament\Support\Media;
use App\Models\Skill;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Profil & CV';

    protected static ?string $modelLabel = 'keahlian';

    protected static ?string $pluralModelLabel = 'keahlian';

    protected static ?string $navigationLabel = 'Keahlian';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(100),
                TextInput::make('proficiency')
                    ->label('Tingkat penguasaan')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
                TextInput::make('group')
                    ->label('Kelompok')
                    ->placeholder('Backend, Frontend, Database...'),
                Media::image('icon', 'skills')->label('Ikon'),
                Toggle::make('is_published')->label('Tampilkan di situs')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('icon')
                    ->label('')
                    ->disk(config('filesystems.media_disk'))
                    ->imageSize(32),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('proficiency')
                    ->label('Penguasaan')
                    ->suffix('%'),
                TextColumn::make('group')
                    ->label('Kelompok')
                    ->placeholder('-'),
                ToggleColumn::make('is_published')
                    ->label('Tampil'),
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
            'index' => ManageSkills::route('/'),
        ];
    }
}
