<?php

use App\RemoteProxy\RestProxyFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'App\Simplex\Controller\BaseController::render',
]));

$routes->add('bye', new Routing\Route('/bye', [
    '_controller' => function (Request $request) {
        $controller = new App\Simplex\Controller\BaseController();

        // $foo will be available in the template
        $request->attributes->set('extra', '+ Extra bye bye Param');

        $response = $controller->render($request);
        // change some header
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    },
]));

$routes->add('leap_year', new Routing\Route('/islpyear/{year}', [
    'year' => null,
    '_controller' => 'App\Calendar\Controller\LeapYearController::index',
]));


$routes->add('api_books_list', new Routing\Route('/books', [
    '_controller' => 'App\Api\Controller\BooksController::list',
]));
$routes->add('api_books_get', new Routing\Route('/books/{id}', [
    '_controller' => 'App\Api\Controller\BooksController::get',
]));
$routes->add('api_books_authors', new Routing\Route('/books/{id}/authors', [
    '_controller' => 'App\Api\Controller\BooksController::getAuthors',
]));

// PROXY Remote Object implementation
// Launch this onto separate shell env before "php -S localhost:9001 -t public"
$apiBasPath = "/api/v1";
$routes->add('api_proxy_books', new Routing\Route($apiBasPath . '/proxy/books/{id<\d+>}/{string<authors>}', [
    'id' => null,
    'string' => null,
    '_controller' => function (Request $request) use ($apiBasPath) {
        $proxy = RestProxyFactory::create('App\RemoteProxy\BooksInterface', 'http://localhost:9001' . $apiBasPath);

        if ($id = $request->attributes->all()['id']) {
            if (strpos($request->getPathInfo(), '/authors') !== false) {
                $data = $proxy->getAuthors($id);
            } else {
                $data = $proxy->getBook($id);
            }
        } else {
            $data = $proxy->getBooks();
        }

        $data->from = "PROXY !!!";

        return new JsonResponse($data);
    },
]));


return $routes;
