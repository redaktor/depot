<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Core\Model;
use Symfony\Component\HttpFoundation\Request;

class GetProfileController
{
    public function action(Model\Entity\EntityInterface $entity)
    {
        return $entity;
    }
}
