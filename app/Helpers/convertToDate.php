<?php

use Carbon\Carbon;

function convertToDate($dateValue)
{
    if (is_numeric($dateValue)) {
        // Excel date system starts on January 1, 1900
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        // Excel incorrectly treats 1900 as a leap year, so we subtract 1 day for dates after Feb 28, 1900
        if ($dateValue > 59) {
            $dateValue -= 1;
        }

        // Add the serial days to the base date
        return $baseDate->addDays($dateValue - 1)->format('d/m/20y');
    } else {
        // If it's already in date format, return it in 'dd/mm/yy' format
        return Carbon::parse($dateValue)->format('d/m/20y');  
    }
}
function convertToDate2($dateValue)
{
    if (is_numeric($dateValue)) {
        // Excel date system starts on January 1, 1900
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        // Excel incorrectly treats 1900 as a leap year, so we subtract 1 day for dates after Feb 28, 1900
        if ($dateValue > 59) {
            $dateValue -= 1;
        }

        // Add the serial days to the base date
        return $baseDate->addDays($dateValue - 1)->format('Y-m-d');  // Store in Y-m-d format
    } else {
        // If it's already in date format, try to parse it
        $date = explode('/', $dateValue);
        
        // If the date has only day and month, assume it's current year
        if (count($date) == 2) {
            $day = $date[1];
            $month = $date[0];
            $year = Carbon::now()->year;  // Default to the current year

            return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');  // Store in Y-m-d format
        } else {
            // If it's a full date, return in Y-m-d format
            return Carbon::parse($dateValue)->format('Y-m-d');
        }
    }
}