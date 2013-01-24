<?php

namespace Depot\Api\Infrastructure\Transport\Guzzle;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Core\Domain\Model\Auth\AuthInterface;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    protected $client;

    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new Client;
    }

    public function head($uri)
    {
        return new GuzzleHttpResponse(
            $this->client->head($uri)->send()
        );
    }

    public function get($uri, $headers = null)
    {
        return new GuzzleHttpResponse(
            $this->client->get($uri)->send()
        );
    }

    public function post($uri, $headers = null, $payload = null)
    {
    }

    public function put($uri, $headers = null, $payload = null)
    {
    }

    public function delete($uri, $headers = null)
    {
    }

    public function with(AuthInterface $auth, $callback)
    {
    }
}
