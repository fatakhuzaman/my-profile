<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Support\Media;
use App\Filament\Support\Seo;
use App\Filament\Support\Translations;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->columnSpanFull()->schema([
                    Section::make('Konten')->columnSpan(2)->schema([
                        ...Translations::titleAndSlug('posts'),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Tampil di daftar artikel & dipakai sebagai meta description bila kosong.')
                            ->rows(3),
                        RichEditor::make('body')
                            ->label('Isi artikel')
                            ->required(Translations::requiredInDefaultLocale())
                            ->fileAttachmentsDisk(config('filesystems.media_disk'))
                            ->fileAttachmentsDirectory('posts/content')
                            ->fileAttachmentsVisibility('public'),
                    ]),
                    Section::make('Publikasi')->columnSpan(1)->schema([
                        DateTimePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->helperText('Kosongkan = draft. Tanggal di masa depan = terjadwal.'),
                        Select::make('user_id')
                            ->label('Penulis')
                            ->relationship('author', 'name')
                            ->default(fn (): ?int => auth()->id())
                            ->preload(),
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Category $record): string => $record->name)
                            ->preload(),
                        Select::make('tags')
                            ->label('Tag')
                            ->relationship('tags', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Tag $record): string => $record->name)
                            ->multiple()
                            ->preload(),
                        Toggle::make('is_featured')->label('Artikel unggulan'),
                        Media::image('cover_image', 'posts')->label('Gambar sampul'),
                    ]),
                ]),
                Seo::section('posts')->columnSpanFull(),
            ]);
    }
}
