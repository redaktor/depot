<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\AuthenticatedHttpClient;
use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\Server;
use Depot\Api\Infrastructure\Transport\Guzzle\GuzzleHttpClient;
use Depot\Core\Domain\Model\Auth\AuthFactory;
use Depot\Core\Domain\Model\Auth\AuthInterface;

class ClientFactory
{
    public static function create(HttpClientInterface $httpClient = null)
    {
        if (null === $httpClient) {
            $httpClient = new GuzzleHttpClient;
        }

        return new Client(
            $httpClient,
            new Server\Discovery($httpClient),
            new Server\Profile($httpClient)
        );
    }
}
