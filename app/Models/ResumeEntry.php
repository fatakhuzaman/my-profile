<?php

namespace App\Models;

use App\Enums\ResumeEntryType;
use App\Models\Concerns\HasPublishedFlag;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\ResumeEntryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static> published()
 * @method static \Illuminate\Database\Eloquent\Builder<static> ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static> ofType(\App\Enums\ResumeEntryType $type)
 */
class ResumeEntry extends Model
{
    /** @use HasFactory<ResumeEntryFactory> */
    use HasFactory, HasPublishedFlag, HasSortOrder, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'title',
        'organization',
        'location',
        'description',
        'url',
        'logo',
        'started_on',
        'ended_on',
        'date_precision',
        'is_published',
        'sort_order',
    ];

    /**
     * The attributes that are stored per locale.
     *
     * @var list<string>
     */
    public array $translatable = [
        'title',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ResumeEntryType::class,
            'started_on' => 'date',
            'ended_on' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<static>  $query
     */
    public function scopeOfType(Builder $query, ResumeEntryType $type): void
    {
        $query->where('type', $type);
    }

    /**
     * Human readable period, e.g. "2023 - 2025", "Jun - Aug 2019" or
     * "2023 - Present". Achievements only show their single date.
     */
    public function period(): string
    {
        $format = $this->date_precision === 'month' ? 'M Y' : 'Y';
        $start = $this->started_on->translatedFormat($format);

        if ($this->type === ResumeEntryType::Achievement) {
            return $start;
        }

        if ($this->ended_on === null) {
            return $start.' - '.__('Present');
        }

        if ($format === 'M Y' && $this->started_on->year === $this->ended_on->year) {
            return $this->started_on->translatedFormat('M').' - '.$this->ended_on->translatedFormat('M Y');
        }

        return $start.' - '.$this->ended_on->translatedFormat($format);
    }
}
