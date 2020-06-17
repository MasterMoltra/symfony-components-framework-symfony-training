<?php

use Symfony\Component\Routing;
use App\Controller\LeapYearController;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'render_template',
]));

$routes->add('bye', new Routing\Route('/bye', [
    '_controller' => function ($request) {
        // $foo will be available in the template
        $request->attributes->set('extra', 'byebye');

        $response = render_template($request);

        // change some header
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
]));

$routes->add('leap_year', new Routing\Route('/islpyear/{year}', [
    'year' => null,
    '_controller' => [new LeapYearController, 'index']
]));
