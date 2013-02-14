<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Core\Model;

class GetProfileInfoController
{
    public function action(Model\Entity\EntityInterface $entity, $type)
    {
        return $entity->findProfileType($type);
    }
}
