<?php

namespace Depot\Api\Server\Symfony\View;

class ViewFactory
{
    protected $jsonResponseFactory;

    public function __construct(JsonResponseFactory $jsonResponseFactory)
    {
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    public function create()
    {
        return new View(array(
            new Renderer\PostListResponseRenderer($this->jsonResponseFactory),
            new Renderer\GenericRenderer($this->jsonResponseFactory),
        ));
    }
}
