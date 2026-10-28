<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;

/**
 * Upload fields that store files on the configured media disk.
 */
class Media
{
    public static function image(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->imageEditor()
            ->disk(config('filesystems.media_disk'))
            ->directory($directory)
            ->visibility('public')
            ->maxSize(4096);
    }

    public static function document(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->disk(config('filesystems.media_disk'))
            ->directory($directory)
            ->visibility('public')
            ->acceptedFileTypes(['application/pdf'])
            ->preserveFilenames()
            ->maxSize(10240);
    }
}
