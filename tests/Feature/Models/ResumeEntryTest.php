<?php

namespace Tests\Feature\Models;

use App\Enums\ResumeEntryType;
use App\Models\ResumeEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ResumeEntryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{ResumeEntryType, string, ?string, string, string}>
     */
    public static function periods(): array
    {
        return [
            'year range' => [ResumeEntryType::Work, '2023-01-01', '2025-01-01', 'year', '2023 - 2025'],
            'ongoing' => [ResumeEntryType::Education, '2023-01-01', null, 'year', '2023 - Present'],
            'months in one year' => [ResumeEntryType::Internship, '2019-06-01', '2019-08-01', 'month', 'Jun - Aug 2019'],
            'months across years' => [ResumeEntryType::Internship, '2019-11-01', '2020-02-01', 'month', 'Nov 2019 - Feb 2020'],
            'achievement' => [ResumeEntryType::Achievement, '2022-02-01', null, 'month', 'Feb 2022'],
        ];
    }

    #[DataProvider('periods')]
    public function test_it_formats_the_period(ResumeEntryType $type, string $startedOn, ?string $endedOn, string $precision, string $expected): void
    {
        app()->setLocale('en');

        $entry = ResumeEntry::factory()->create([
            'type' => $type,
            'started_on' => $startedOn,
            'ended_on' => $endedOn,
            'date_precision' => $precision,
        ]);

        $this->assertSame($expected, $entry->period());
    }

    public function test_it_filters_by_type(): void
    {
        $work = ResumeEntry::factory()->ofType(ResumeEntryType::Work)->create();
        ResumeEntry::factory()->ofType(ResumeEntryType::Education)->create();

        $this->assertEquals([$work->id], ResumeEntry::ofType(ResumeEntryType::Work)->pluck('id')->all());
    }
}
