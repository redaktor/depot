<?php

namespace Depot\Core\Domain\Service\Json;

interface RendererInterface
{
    public function supports($object);
    public function renderToData($object);
}
