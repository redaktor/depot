<?php

namespace Depot\Api\Server\Symfony\View;

class View implements ViewInterface
{
    public function __construct(array $renderers = null)
    {
        $this->renderers = $renderers ?: array();
    }

    public function render($object)
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($object)) {
                return $renderer->render($object);
            }
        }
    }
}
