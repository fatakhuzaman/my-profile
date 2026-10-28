<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ResumeEntryType: string implements HasLabel
{
    case Work = 'work';
    case Internship = 'internship';
    case Education = 'education';
    case Achievement = 'achievement';

    public function label(): string
    {
        return match ($this) {
            self::Work => __('Professional Experience'),
            self::Internship => __('Internship Experience'),
            self::Education => __('Education'),
            self::Achievement => __('Achievements'),
        };
    }

    public function getLabel(): string
    {
        return $this->label();
    }
}
