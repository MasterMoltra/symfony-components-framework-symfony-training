<?php

namespace App\Calendar\Controller;

use App\Calendar\Model\LeapYear;
use App\Simplex\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController extends AbstractController
{
    public function index(?int $year): Response
    {
        $leapYear = new LeapYear();
        if ($leapYear->isLeapYear($year)) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }
}
