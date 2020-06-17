<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();
