<?php

namespace App\RemoteProxy\Annotation;

/**
 * @Annotation
 * Class Endpoint
 * @package RemoteProxy\Annotation
 */
class Endpoint
{
    /**
     * @var String
     */
    public $path;

    /**
     * @var String
     */
    public $method;

    public function __construct(array $parameters)
    {
        $this->path = $parameters['path'];

        $this->method = isset($parameters['method']) ? $parameters['method'] : 'get';
    }
}
