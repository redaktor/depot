<?php

namespace Depot\Core\Service\Json;

interface RendererInterface
{
    public function supports($object);
    public function renderToData($object);
}
