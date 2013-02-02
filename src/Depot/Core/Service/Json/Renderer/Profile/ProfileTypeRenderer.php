<?php

namespace Depot\Core\Service\Json\Renderer\Profile;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class ProfileTypeRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\Entity\ProfileTypeInterface;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\Entity\ProfileTypeInterface) {
            throw \InvalidArgumentException('Expected Model\Entity\ProfileTypeInterface type');
        }

        return $object->content();
    }
}
