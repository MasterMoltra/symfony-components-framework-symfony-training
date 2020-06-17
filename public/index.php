<?php
require_once __DIR__ . '/../src/init.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function render_template($request)
{
    var_dump($request->attributes->all());

    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__ . '/../src/front/%s.php', $_route);

    return new Response(ob_get_clean());
}

$context = new Routing\RequestContext();
$context->fromRequest($request);
// $matcher = new Routing\Matcher\UrlMatcher($routes, $context);
// For better performance convert in a plain PHP array
$compiledRoutes = (new Routing\Matcher\Dumper\CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
$matcher = new Routing\Matcher\CompiledUrlMatcher($compiledRoutes, $context);

// echo "<pre>";
// print_r($routes);
// print_r($compiledRoutes);
// echo "</pre>";

// var_dump($matcher->match($request->getPathInfo()));
// var_dump($matcher->match('/not-found'));

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred', 500);
}

// $generator = new Routing\Generator\UrlGenerator($routes, $context);
// $genUrl = $generator->generate(
//     'hello',
//     ['name' => 'Marco'],
//     Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
// );
// var_dump($genUrl);

$response->send();
