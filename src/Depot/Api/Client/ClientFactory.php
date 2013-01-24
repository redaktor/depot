<?php

namespace Depot\Api\Client;

use Depot\Api\Client\Server;
use Depot\Api\Infrastructure\Transport\Guzzle\GuzzleHttpClient;

class ClientFactory
{
    public static function create(HttpClientInterface $httpClient = null)
    {
        if (null === $httpClient) {
            $httpClient = new GuzzleHttpClient;
        }

        return new Client(
            new Server\Discovery($httpClient),
            new Server\Profile($httpClient)
        );
    }
}
