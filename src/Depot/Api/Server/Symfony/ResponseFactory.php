<?php

namespace Depot\Api\Server\Symfony;

use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    public function createTentJsonResponse($payload, array $headers = null)
    {
        $response = new Response();
        $response->setContent($payload);

        if ($headers) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
        }

        if (!$headers || !isset($headers['Content-Type'])) {
            $response->headers->set('Content-Type', 'application/vnd.tent.v0+json');
        }

        return $response;
    }
}
