<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Simplex\Events;

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Events\ContentLengthListener());
$dispatcher->addSubscriber(new Events\GoogleListener());

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
