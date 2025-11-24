<?php

namespace App\Console\Commands;

use App\Models\Journaling;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateYearlyJournaling extends Command
{
    protected $signature = 'journalings:generate';

    protected $description = 'Generate weekly journals for current year and assign all users';

    public function handle()
    {
        $currentYear = now()->year;
        $weeksInYear = Carbon::parse("$currentYear-01-01")->weeksInYear;

        for ($week = 1; $week <= $weeksInYear; $week++) {
            Journaling::firstOrCreate([
                'year' => $currentYear,
                'week' => $week,
            ]);
        }
        $this->info("✅ Weekly journal slots for {$currentYear} generated successfully.");
    }
}
