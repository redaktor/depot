<?php

namespace Depot\Core\Service\Json\Renderer\Profile;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class ProfileRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\Entity\ProfileInterface;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\Entity\ProfileInterface) {
            throw \InvalidArgumentException('Expected Model\Entity\ProfileInterface type');
        }

        $types = array();

        foreach ($object->types() as $type) {
            $info = $object->find($type);

            $types[$info->uri()] = $info->content();
        }

        return $types;
    }
}
