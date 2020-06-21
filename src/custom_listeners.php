<?php

use App\Simplex\Events\GoogleListener;
use App\Simplex\Events\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;

$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall(
        'addSubscriber',
        [new Reference('listener.string_response')]
    );

$container->register('listener.google_code', GoogleListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall(
        'addSubscriber',
        [new Reference('listener.google_code')]
    );
