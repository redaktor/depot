<?php

namespace Depot\Api\Client;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Api\Client\HttpClient\GuzzleHttpClient;
use Depot\Api\Client\Server;
use Depot\Core\Model\Auth\AuthFactory;
use Depot\Core\Service\Random\Random;
use Depot\Core\Service\Random\RandomInterface;
use Depot\Core\Service\Serializer\SerializerFactory;
use Symfony\Component\Serializer\SerializerInterface;


class ClientFactory
{
    public function create(HttpClientInterface $httpClient = null, AuthFactory $authFactory = null, RandomInterface $random = null, SerializerInterface $serializer = null)
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

        if (null === $serializer) {
            $serializerFactory = new SerializerFactory($authFactory);
            $serializer = $serializerFactory->create();
        }

        return new Client(
            $this,
            $httpClient,
            new Server\Discovery($serializer, $httpClient),
            new Server\Profile($serializer, $httpClient),
            new Server\Apps($serializer, $httpClient, $authFactory, $random),
            new Server\Posts($serializer, $httpClient)
        );
    }
}
