<?php

namespace Depot\Core\Service\Json\Renderer\Entity;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class ProfileInfoRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\Entity\ProfileInfoInterface;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\Entity\ProfileInfoInterface) {
            throw \InvalidArgumentException('Expected Model\Entity\ProfileInfoInterface type');
        }

        return $object->content();
    }
}
