<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\Server;
use Depot\Api\Infrastructure\Transport\Guzzle\GuzzleHttpClient;
use Depot\Core\Domain\Model\Auth\AuthFactory;
use Depot\Core\Domain\Service\Random\Random;
use Depot\Core\Domain\Service\Random\RandomInterface;

class ClientFactory
{
    public static function create(HttpClientInterface $httpClient = null, AuthFactory $authFactory = null, RandomInterface $random = null)
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
            $httpClient,
            new Server\Discovery($httpClient),
            new Server\Profile($httpClient),
            new Server\App($httpClient, $authFactory, $random)
        );
    }
}
