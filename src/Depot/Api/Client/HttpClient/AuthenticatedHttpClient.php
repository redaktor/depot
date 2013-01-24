<?php

namespace Depot\Api\Client\HttpClient;

use Depot\Core\Domain\Model\Auth\AuthInterface;
use Depot\Core\Domain\Model\Auth\HmacHelper;

class AuthenticatedHttpClient implements HttpClientInterface
{
    protected $httpClient;
    protected $auth;

    public function __construct(HttpClientInterface $httpClient, AuthInterface $auth)
    {
        $this->httpClient = $httpClient;
        $this->auth = $auth;
    }

    public function head($uri)
    {
        return $this->httpClient->head($uri);
    }

    public function get($uri, $headers = null)
    {
        $headers = $this->massageHeaders('GET', $uri, $headers);

        return $this->httpClient->get($uri, $headers);
    }

    public function post($uri, $headers = null, $payload = null)
    {
        $headers = $this->massageHeaders('POST', $uri, $headers);

        return $this->httpClient->post($uri, $headers, $payload);
    }

    public function put($uri, $headers = null, $payload = null)
    {
        $headers = $this->massageHeaders('PUT', $uri, $headers);

        return $this->httpClient->put($uri, $headers, $payload);
    }

    public function delete($uri, $headers = null)
    {
        $headers = $this->massageHeaders('DELETE', $uri, $headers);

        return $this->httpClient->delete($uri, $headers);
    }

    protected function massageHeaders($method, $uri, $headers = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        if ($this->auth->isAnonymous()) {
            return $headers;
        }

        $headers['Authorization'] = HmacHelper::generateAuthorizationHeader(
            $method,
            $uri,
            $this->auth->macKeyId(),
            $this->auth->macKey()
        );

        return $headers;
    }
}
