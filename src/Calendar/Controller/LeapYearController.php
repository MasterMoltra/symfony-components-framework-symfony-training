<?php

namespace App\Calendar\Controller;

use App\Calendar\Model\LeapYear;
use App\Simplex\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController extends AbstractController
{
    public function index(?int $year)
    {
        if ($year === 0000) {
            return "Return a string instead ok an object from the controller!!!";
        }

        $leapYear = new LeapYear();
        if ($leapYear->isLeapYear($year)) {
            $response = new Response('Yep, this is a leap year!' . rand());
        } else {
            $response = new Response('Nope, this is not a leap year.' . rand());
        }

        $response->setTtl(30); // cache the response for 30 seconds

        return $response;
    }
}
