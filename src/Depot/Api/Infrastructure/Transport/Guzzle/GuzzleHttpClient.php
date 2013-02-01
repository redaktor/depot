<?php

namespace Depot\Api\Infrastructure\Transport\Guzzle;

use Depot\Api\Client\HttpClient\HttpClientInterface;
use Depot\Core\Model\Auth\AuthInterface;
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
        if (null === $headers) {
            $headers = array();
        }

        return new GuzzleHttpResponse(
            $this->client->get($uri, $headers)->send()
        );
    }

    public function post($uri, $headers = null, $payload = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        return new GuzzleHttpResponse(
            $this->client->post($uri, $headers, $payload)->send()
        );
    }

    public function put($uri, $headers = null, $payload = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        return new GuzzleHttpResponse(
            $this->client->put($uri, $headers, $payload)->send()
        );
    }

    public function delete($uri, $headers = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        return new GuzzleHttpResponse(
            $this->client->put($uri, $headers)->send()
        );
    }
}
