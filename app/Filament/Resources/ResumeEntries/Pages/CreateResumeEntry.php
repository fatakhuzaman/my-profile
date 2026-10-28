<?php

namespace App\Filament\Resources\ResumeEntries\Pages;

use App\Filament\Resources\ResumeEntries\ResumeEntryResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateResumeEntry extends CreateRecord
{
    use Translatable;

    protected static string $resource = ResumeEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
