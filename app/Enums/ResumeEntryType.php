<?php

namespace App\Enums;

enum ResumeEntryType: string
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
}
