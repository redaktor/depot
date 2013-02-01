<?php

namespace Depot\Api\Client\HttpClient;

use Depot\Core\Model\Auth\AuthInterface;
use Depot\Core\Model\Auth\HmacHelper;

abstract class AbstractHttpClientDecorator implements HttpClientInterface
{
    protected $httpClient;

    public function head($uri)
    {
        $headers = $this->massageHeaders('HEAD', $uri);

        return $this->massageResponse($this->httpClient->head($uri));
    }

    public function get($uri, $headers = null)
    {
        $headers = $this->massageHeaders('GET', $uri, $headers);

        return $this->massageResponse($this->httpClient->get($uri, $headers));
    }

    public function post($uri, $headers = null, $payload = null)
    {
        $headers = $this->massageHeaders('POST', $uri, $headers);

        return $this->massageResponse($this->httpClient->post($uri, $headers, $payload));
    }

    public function put($uri, $headers = null, $payload = null)
    {
        $headers = $this->massageHeaders('PUT', $uri, $headers);

        return $this->massageResponse($this->httpClient->put($uri, $headers, $payload));
    }

    public function delete($uri, $headers = null)
    {
        $headers = $this->massageHeaders('DELETE', $uri, $headers);

        return $this->massageResponse($this->httpClient->delete($uri, $headers));
    }

    protected function massageHeaders($method, $uri, $headers = null)
    {
        return $headers;
    }

    protected function massageResponse(HttpResponseInterface $response)
    {
        return $response;
    }
}
