<?php

namespace Depot\Api\Client\HttpClient;

use Depot\Core\Model\Auth\AuthInterface;
use Depot\Core\Model\Auth\HmacHelper;

class AuthenticatedHttpClient extends AbstractHttpClientDecorator
{
    protected $auth;

    public function __construct(HttpClientInterface $httpClient, AuthInterface $auth)
    {
        $this->httpClient = $httpClient;
        $this->auth = $auth;
    }

    protected function massageHeaders($method, $uri, $headers = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        if ($this->auth->isAnonymous() || isset($headers['Authorization'])) {
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
