<?php

namespace App\Simplex\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class GoogleListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if (
            $response->isRedirection()
            || ($response->headers->has('Content-Type')
                && false === strpos(
                    $response->headers->get('Content-Type'),
                    'html'
                ))
            || 'html' !== $event->getRequest()->getRequestFormat()
        ) {
            return;
        }

        $response->setContent($response->getContent() . 'GA CODE');
    }

    public static function getSubscribedEvents()
    {
        return ['kernel.response' => 'onResponse'];
    }
}
