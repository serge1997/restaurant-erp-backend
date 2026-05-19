<?php

use Illuminate\Support\Carbon;

if (!function_exists('formatMinutes')){
    function dateToTimeHurmanFormat(?Carbon $carbon){
        if (!$carbon) return null;
        $min = $carbon->min()->minute;
        $hour = $carbon->hour;
       return $hour ? "{$hour}h {$min}" : "{$min} min";
    }
}

if (!function_exists('formatMinutes')){
    function dayForHuman(int $dayDiff): string
    {
        return match($dayDiff) {
            0 => 'Hoje',
            1 => 'Ontem',
            2 => 'Anteontem',
            default => "+{$dayDiff} dias"
        };
    }
}