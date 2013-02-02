<?php

namespace Depot\Core\Model\Entity;

class MemoryEntityRepository implements EntityRepositoryInterface
{
    protected $entities = array();

    public function findByUri($uri)
    {
        if (isset($this->entities[$uri])) {
            return $this->entities[$uri];
        }

        return null;
    }

    public function store(EntityInterface $entity)
    {
        $this->entities[$entity->uri()] = $entity;
    }

    public function remove(EntityInterface $entity)
    {
        if (isset($this->entities[$entity->uri()])) {
            unset($this->entities[$entity->uri()]);
        }
    }
}
