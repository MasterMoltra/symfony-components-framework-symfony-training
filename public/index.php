<?php

require_once __DIR__ . '/../src/init.php';

$framework = new App\Simplex\Framework($matcher, $controllerResolver, $argumentResolver);

$response = $framework->handle($request);
$response->send();
