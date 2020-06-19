<?php

use Symfony\Component\HttpKernel;

require_once __DIR__ . '/../src/init.php';

$framework = new App\Simplex\Framework($matcher, $controllerResolver, $argumentResolver, $dispatcher);
$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__ . '/../cache'),
    new HttpKernel\HttpCache\Esi(),
    ['debug' => true]
);
$response = $framework->handle($request);
$response->send();
