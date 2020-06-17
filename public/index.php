<?php
require_once __DIR__ . '/../src/init.php';

$map = [
    '/hello' => 'hello',
    '/bye'   => 'bye',
];

$path = $request->getPathInfo();
if (isset($map[$path])) {
    ob_start();
    include sprintf(__DIR__ . '/../src/front/%s.php', $map[$path]);
    $response->setContent(ob_get_clean());
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();
