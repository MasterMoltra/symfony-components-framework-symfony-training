<?php

use App\Controller\BaseController;
use App\Controller\LeapYearController;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => [new BaseController, 'render_template']
]));

$routes->add('bye', new Routing\Route('/bye', [
    '_controller' => function ($request) {
        $controller = new BaseController();

        // $foo will be available in the template
        $request->attributes->set('extra', 'byebye');

        $response = $controller->render_template($request);
        // change some header
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
]));

$routes->add('leap_year', new Routing\Route('/islpyear/{year}', [
    'year' => null,
    '_controller' => [new LeapYearController, 'index']
]));
