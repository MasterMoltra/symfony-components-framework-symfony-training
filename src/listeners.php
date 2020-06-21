<?php

/** NOTICE: THIS FILE HAS BEEN COMPLETELY REPLACED BY THE DEPENDENCY INJECTION LOGIC */

use App\Simplex\Events;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener;

$dispatcher = new EventDispatcher();

// Error event handler
$errorListener = new EventListener\ErrorListener(
    'App\Simplex\Controller\ErrorController::exception'
);

// Validate Response before send
$dispatcher->addSubscriber(new EventListener\ResponseListener('UTF-8'));

$dispatcher->addSubscriber($errorListener);
$dispatcher->addSubscriber(new Events\ContentLengthListener());
$dispatcher->addSubscriber(new Events\GoogleListener());

// If controller return a string cast to an Response object (not needed if use typeHint)
$dispatcher->addSubscriber(new Events\StringResponseListener());
//** LISTENERS MOVED INTO SEPARATE CLASSES  */
// this dispatcher order is important!
// $dispatcher->addListener('response', function (App\Simplex\Events\ResponseEvent $event) {
//     $response = $event->getResponse();
//     $headers = $response->headers;

//     if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
//         $headers->set('Content-Length', strlen($response->getContent()));
//     }
// }, -255);

// $dispatcher->addListener('response', function (App\Simplex\Events\ResponseEvent $event) {
//     $response = $event->getResponse();

//     if (
//         $response->isRedirection()
//         || ($response->headers->has('Content-Type')
//             && false === strpos(
//                 $response->headers->get('Content-Type'),
//                 'html'
//             ))
//         || 'html' !== $event->getRequest()->getRequestFormat()
//     ) {
//         return;
//     }

//     $response->setContent($response->getContent() . 'GA CODE');
// });

return $dispatcher;
