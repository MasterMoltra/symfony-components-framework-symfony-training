<?php

namespace App\Calendar\Controller;

use App\Simplex\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Calendar\Model\LeapYear;

class LeapYearController extends AbstractController
{
    public function index(?int $year): Response
    {
        $leapYear = new LeapYear;
        if ($leapYear->is_leap_year($year)) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }
}
