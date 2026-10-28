<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Support\Media;
use App\Filament\Support\Seo;
use App\Filament\Support\Translations;
use App\Models\ProjectCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->columnSpanFull()->schema([
                    Section::make('Konten')->columnSpan(2)->schema([
                        ...Translations::titleAndSlug('projects'),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3),
                        RichEditor::make('body')
                            ->label('Studi kasus')
                            ->helperText('Masalah klien, solusi, teknologi, dan hasilnya.')
                            ->fileAttachmentsDisk(config('filesystems.media_disk'))
                            ->fileAttachmentsDirectory('projects/content')
                            ->fileAttachmentsVisibility('public'),
                        Grid::make(2)->schema([
                            TextInput::make('role')
                                ->label('Peran / layanan')
                                ->placeholder('Full Stack Development'),
                            TextInput::make('client_name')
                                ->label('Klien'),
                            TextInput::make('year')
                                ->label('Tahun')
                                ->numeric()
                                ->minValue(2000)
                                ->maxValue(2100),
                            TextInput::make('project_url')
                                ->label('Link proyek')
                                ->url(),
                            TextInput::make('repository_url')
                                ->label('Link repository')
                                ->url(),
                            TextInput::make('video_url')
                                ->label('Link video (YouTube)')
                                ->url(),
                        ]),
                    ]),
                    Section::make('Publikasi')->columnSpan(1)->schema([
                        DateTimePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->helperText('Kosongkan untuk menyimpan sebagai draft.'),
                        Select::make('categories')
                            ->label('Kategori')
                            ->relationship('categories', 'name')
                            ->getOptionLabelFromRecordUsing(fn (ProjectCategory $record): string => $record->name)
                            ->multiple()
                            ->preload(),
                        Toggle::make('is_featured')->label('Tampilkan di beranda'),
                        Media::image('cover_image', 'projects')->label('Gambar sampul'),
                        Media::image('gallery', 'projects/gallery')
                            ->label('Galeri')
                            ->multiple()
                            ->reorderable(),
                    ]),
                ]),
                Seo::section('projects')->columnSpanFull(),
            ]);
    }
}
