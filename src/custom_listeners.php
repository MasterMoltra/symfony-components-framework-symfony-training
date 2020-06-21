<?php

use App\Simplex\Events;

return [
    Events\StringResponseListener::class => [
        'listener.string_response',
        'addSubscriber',
    ],
    Events\GoogleListener::class => [
        'listener.google_code',
        'addSubscriber',
    ],
];
