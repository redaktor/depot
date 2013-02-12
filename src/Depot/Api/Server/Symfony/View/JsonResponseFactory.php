<?php

namespace Depot\Api\Server\Symfony\View;

use Depot\Core\Service\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseFactory
{
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function create($object, $code = null)
    {
        return new Response(
            $this->serializer->serialize($object),
            $code ?: 200,
            array('Content-Type', 'application/vnd.tent.v0+json')
        );
    }
}
