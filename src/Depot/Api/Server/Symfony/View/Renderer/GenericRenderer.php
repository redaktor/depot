<?php

namespace Depot\Api\Server\Symfony\View\Renderer;

use Depot\Core\Model;
use Depot\Api\Server\Symfony\View\JsonResponseFactory;

class GenericRenderer implements RendererInterface
{
    protected $jsonResponseFactory;

    public function __construct(JsonResponseFactory $jsonResponseFactory)
    {
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    public function supports($object)
    {
        return $object instanceof Model\Entity\EntityInterface;
    }

    public function render($object)
    {
        return $this->jsonResponseFactory->create($object);
    }
}
