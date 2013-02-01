<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\Server;
use Depot\Api\Infrastructure\Transport\Guzzle\GuzzleHttpClient;
use Depot\Core\Model\Auth\AuthFactory;
use Depot\Core\Service\Random\Random;
use Depot\Core\Service\Random\RandomInterface;

class ClientFactory
{
    public function create(HttpClientInterface $httpClient = null, AuthFactory $authFactory = null, RandomInterface $random = null)
    {
        if (null === $httpClient) {
            $httpClient = new GuzzleHttpClient;
        }

        if (null === $authFactory) {
            $authFactory = new AuthFactory;
        }

        if (null === $random) {
            $random = new Random;
        }

        return new Client(
            $this,
            $httpClient,
            new Server\Discovery($httpClient),
            new Server\Profile($httpClient),
            new Server\Apps($httpClient, $authFactory, $random),
            new Server\Posts($httpClient)
        );
    }
}
