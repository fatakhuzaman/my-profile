<?php

namespace App\Filament\Resources\ResumeEntries\Pages;

use App\Filament\Resources\ResumeEntries\ResumeEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditResumeEntry extends EditRecord
{
    use Translatable;

    protected static string $resource = ResumeEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
