<?php

namespace Depot\Api\Client\HttpClient;

class TentHttpClient extends AbstractHttpClientDecorator
{
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function massageHeaders($method, $uri, $headers = null)
    {
        if (null === $headers) {
            $headers = array();
        }

        if (!isset($headers['Content-Type']) && !in_array($method, array('HEAD', 'GET'))) {
            $headers['Content-Type'] = 'application/vnd.tent.v0+json';
        }

        if (!isset($headers['Accept'])) {
            $headers['Accept'] = 'application/vnd.tent.v0+json';
        }

        return $headers;
    }
}
