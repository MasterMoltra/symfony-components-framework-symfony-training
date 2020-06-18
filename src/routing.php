<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'App\Simplex\Controller\BaseController::render_template'
]));

$routes->add('bye', new Routing\Route('/bye', [
    '_controller' => function (Request $request) {
        $controller = new App\Simplex\Controller\BaseController;

        // $foo will be available in the template
        $request->attributes->set('extra', '+ Extra bye bye Param');

        $response = $controller->render_template($request);
        // change some header
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
]));

$routes->add('leap_year', new Routing\Route('/islpyear/{year}', [
    'year' => null,
    '_controller' => 'App\Calendar\Controller\LeapYearController::index'
]));
