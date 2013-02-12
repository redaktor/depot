<?php

namespace Depot\Api\Server\Symfony\View\Renderer;

interface RendererInterface
{
    public function supports($object);
    public function render($object);
}
