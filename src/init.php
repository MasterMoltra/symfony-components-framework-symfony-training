<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

// INIT AUTOLOAD
require_once __DIR__ . '/../vendor/autoload.php';

// INIT HTTP REQUEST
$request = Request::createFromGlobals();
$requestStack = new RequestStack();
// $response = new Response();

// INIT ROUTING
$routes = include __DIR__ . '/routing.php';
$context = new Routing\RequestContext();
// $context->fromRequest($request);
// For better performance convert in a plain PHP array
// $matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$compiledRoutes = (new Routing\Matcher\Dumper\CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
$matcher = new Routing\Matcher\CompiledUrlMatcher($compiledRoutes, $context);

// INIT DISPATCHER/LSTENERS
$dispatcher = include __DIR__ . '/listeners.php';
// Routing event
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));

// INIT HTTP KERNEL RESOLVER
$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

// echo "<pre>";
// print_r($routes);
// print_r($compiledRoutes);
// echo "</pre>";

// var_dump($matcher->match($request->getPathInfo()));
// var_dump($matcher->match('/not-found'));

// $generator = new Routing\Generator\UrlGenerator($routes, $context);
// $genUrl = $generator->generate(
//     'hello',
//     ['name' => 'Marco'],
//     Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL
// );
// var_dump($genUrl);
