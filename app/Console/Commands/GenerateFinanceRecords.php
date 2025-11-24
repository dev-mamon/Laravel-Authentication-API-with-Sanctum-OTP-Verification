<?php

namespace App\Console\Commands;

use App\Models\Finance;
use Illuminate\Console\Command;

class GenerateFinanceRecords extends Command
{
    protected $signature = 'finance:generate';

    protected $description = 'Automatically generate monthly finance records for the current year';

    public function handle()
    {
        $year = now()->year;
        $months = range(1, 12);

        foreach ($months as $month) {
            $exists = Finance::where('year', $year)
                ->where('month', $month)
                ->exists();

            if (! $exists) {
                Finance::create([
                    'year' => $year,
                    'month' => $month,
                ]);

                $this->info("Finance record created: Year {$year}, Month {$month}");
            }
        }

        $this->info('✅ Finance data generation complete.');
    }
}
