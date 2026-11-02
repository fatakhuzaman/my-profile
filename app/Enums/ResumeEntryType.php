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

    /**
     * Remix Icon class shown next to each entry of this type.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Work => 'ri-book-marked-line',
            self::Internship => 'ri-book-line',
            self::Education => 'ri-school-line',
            self::Achievement => 'ri-award-fill',
        };
    }

    /**
     * Whether the entry's title (degree, award) leads instead of the
     * organization (employer).
     */
    public function leadsWithTitle(): bool
    {
        return in_array($this, [self::Education, self::Achievement], true);
    }
}
