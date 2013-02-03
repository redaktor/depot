<?php

namespace Depot\Core\Service\Json\Renderer\Entity;

use Depot\Core\Model;
use Depot\Core\Service\Json\RendererInterface;

class EntityRenderer implements RendererInterface
{
    public function supports($object)
    {
        return $object instanceof Model\Entity\EntityInterface;
    }

    public function renderToData($object)
    {
        if (!$object instanceof Model\Entity\EntityInterface) {
            throw \InvalidArgumentException('Expected Model\Entity\EntityInterface type');
        }

        $types = array();

        foreach ($object->profileInfoTypes() as $type) {
            $info = $object->findProfileInfo($type);

            $types[$info->uri()] = $info->content();
        }

        return $types;
    }
}
