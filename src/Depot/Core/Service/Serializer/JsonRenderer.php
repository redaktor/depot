<?php

namespace Depot\Core\Service\Json;

class JsonRenderer implements JsonRendererInterface
{
    protected $renderers;

    public function __construct()
    {
        $this->renderers = array(
            new Renderer\Apps\AppRegistrationCreationResponseRenderer,
            new Renderer\Apps\AppRegistrationResponseRenderer,

            new Renderer\Entity\EntityRenderer,
            new Renderer\Entity\ProfileInfoRenderer,
        );
    }

    public function render($object)
    {
        foreach ($this->renderers as $renderer) {
            if ($renderer->supports($object)) {
                return json_encode($renderer->renderToData($object));
            }
        }

        throw new \RuntimeException('Could not find a renderer for object of class '.get_class($object));
    }
}
