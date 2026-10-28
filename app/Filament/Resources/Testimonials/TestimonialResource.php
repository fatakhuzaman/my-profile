<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Filament\Support\Media;
use App\Filament\Support\Translations;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class TestimonialResource extends Resource
{
    use Translatable;

    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|UnitEnum|null $navigationGroup = 'Profil & CV';

    protected static ?string $modelLabel = 'testimoni';

    protected static ?string $pluralModelLabel = 'testimoni';

    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'author_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('author_name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('author_title')
                    ->label('Jabatan')
                    ->placeholder('CEO'),
                TextInput::make('company')
                    ->label('Perusahaan'),
                Select::make('rating')
                    ->label('Rating')
                    ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★']),
                Textarea::make('quote')
                    ->label('Testimoni')
                    ->required(Translations::requiredInDefaultLocale())
                    ->rows(4)
                    ->columnSpanFull(),
                Media::image('avatar', 'testimonials')
                    ->label('Foto')
                    ->avatar(),
                Toggle::make('is_published')->label('Tampilkan di situs')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->disk(config('filesystems.media_disk'))
                    ->circular(),
                TextColumn::make('author_name')
                    ->label('Nama')
                    ->description(fn (Testimonial $record): ?string => $record->company)
                    ->searchable(),
                TextColumn::make('quote')
                    ->label('Testimoni')
                    ->limit(60),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (?int $state): string => str_repeat('★', (int) $state))
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
            'index' => ManageTestimonials::route('/'),
        ];
    }
}
