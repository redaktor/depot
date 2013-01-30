<?php

namespace Depot\Core\Model\Server;

use Depot\Core\Model\Entity\EntityInterface;

class Server implements ServerInterface
{
    protected $entity;

    public function __construct(EntityInterface $entity)
    {
        $this->entity = $entity;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function servers()
    {
        $json = $this->entity->profile()->find('https://tent.io/types/info/core/v0.1.0')->content();

        return $json['servers'];
    }
}
