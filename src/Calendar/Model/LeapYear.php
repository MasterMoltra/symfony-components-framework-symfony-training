<?php

namespace App\Calendar\Model;

class LeapYear
{
    public function is_leap_year(?int $year = null): int
    {
        if (null === $year) {
            $year = date('Y');
        }

        return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
    }
}
