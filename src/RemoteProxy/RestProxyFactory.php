<?php

namespace App\RemoteProxy;

use App\RemoteProxy\Adapter\RestAdapter;
use ProxyManager\Factory\RemoteObjectFactory;
use GuzzleHttp\Client;

class RestProxyFactory
{
    /**
     * Create a Restful remote object proxy
     *
     * @param  string $interface
     * @param  string $base_uri
     *
     * @return \ProxyManager\Proxy\RemoteObjectInterface
     */
    public static function create($interface, $base_uri)
    {
        $uriResolver = (new UriResolver())->getMappings($interface);

        $factory = new RemoteObjectFactory(
            new RestAdapter(
                new Client([
                    'base_uri' => rtrim($base_uri, '/') . '/',
                ]),
                $uriResolver
            )
        );
        return $factory->createProxy($interface);
    }
}
