<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Core\Model;

class GetProfileController
{
    public function action(Model\Entity\EntityInterface $entity)
    {
        return $entity;
    }
}
