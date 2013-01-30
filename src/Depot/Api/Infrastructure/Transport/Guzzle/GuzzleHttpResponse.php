<?php

namespace Depot\Api\Infrastructure\Transport\Guzzle;

use Depot\Api\Client\HttpClient\HttpResponseInterface;
use Guzzle\Http\Message\Response;

class GuzzleHttpResponse implements HttpResponseInterface
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function headers()
    {
        return $this->response->getHeaders();
    }

    public function header($header)
    {
        $guzzleHeader = $this->response->getHeader($header);

        if ($guzzleHeader) {
            return explode($guzzleHeader->getGlue(), $guzzleHeader);
        }

        return array();
    }

    public function body()
    {
        return $this->response->getBody();
    }
}
