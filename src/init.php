<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/routing.php';

use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

// INIT HTTP
$request = Request::createFromGlobals();
// $response = new Response();

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
