<?php

use Symfony\Component\HttpKernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../src/container.php';
$container->setParameter('routes', include __DIR__ . '/../src/routing.php');
$container->setParameter('charset', 'UTF-8');

$request = Request::createFromGlobals();

$framework = $container->get('framework');
// $framework = new App\Simplex\Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__ . '/../cache'),
    new HttpKernel\HttpCache\Esi(),
    ['debug' => true]
);

$response = $framework->handle($request);
$response->send();
