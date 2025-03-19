<?php

namespace App\Console\Commands;

use App\Models\Monthly;
use App\Models\Record;
use App\Models\Target;
use Illuminate\Console\Command;

class UpdateMonthlyTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:monthly-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update monthly totals for entries';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the current date
        $endDate = now();

        // Calculate the start date of the previous month
        $startDate = $endDate->copy()->subMonth()->startOfMonth();

        // Calculate the end date of the previous month
        $endDate = $endDate->copy()->subMonth()->endOfMonth();

        // Retrieve entries within the previous month
        $entries = Record::whereBetween('created_at', [$startDate, $endDate])->get();

        $monthly_target = Target::where('id', 2)->first();

        // Calculate monthly totals
        $monthlyTotals = [
            'screened' => $entries->sum('screened'),
            'presumptive' => $entries->sum('presumptive'),
            'positive' => $entries->sum('positive'),
            'linked' => $entries->sum('linked'),
            'negative' => $entries->sum('negative'),
            'pending' => $entries->sum('pending'),
            'invalid' => $entries->sum('invalid'),
            'month' => $startDate->month, // Month of the start date
            'year' => $startDate->year, // Year of the start date
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        $performance = [
            'performance_screened' => intval(number_format(($monthlyTotals['screened'] / ($monthly_target->screened * 10)) * 100, 0)),
            'performance_presumptive' => intval(number_format(($monthlyTotals['presumptive'] / ($monthly_target->presumptive * 10)) * 100, 0)),
            'performance_positive' => intval(number_format(($monthlyTotals['positive'] / ($monthly_target->positive * 10)) * 100, 0)),
            'performance_linked' => intval(number_format(($monthlyTotals['linked'] / ($monthly_target->linked * 10)) * 100, 0))
        ];

        // Merge $weeklyTotals and $performance into a single array
        $attributes = array_merge($monthlyTotals, $performance);

        // Update or create a Monthly record
        Monthly::updateOrCreate(
            ['month' => $startDate->month, 'year' => $startDate->year], // Check if record already exists for this month and year
            $attributes
        );
    }
}
