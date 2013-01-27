<?php

namespace Depot\Core\Domain\Service\Json;

class JsonRenderer implements JsonRendererInterface
{
    protected $renderers;

    public function __construct()
    {
        $this->renderers = array(
            new Renderer\App\AppRegistrationCreationResponseRenderer,
            new Renderer\App\AppRegistrationResponseRenderer,
        );
    }

    public function render($object)
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($object)) {
                return json_encode($this->renderToData($object));
            }
        }
    }
}
