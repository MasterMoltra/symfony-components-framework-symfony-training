<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class LeapYearController extends AbstractController
{
    public function index(?int $year): Response
    {
        if ($this->is_leap_year($year)) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }

    private function is_leap_year($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
    }
}
