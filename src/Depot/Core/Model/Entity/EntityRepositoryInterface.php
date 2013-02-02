<?php

namespace Depot\Core\Model\Entity;

interface EntityRepositoryInterface
{
    public function findByUri($uri);
    public function store(EntityInterface $entity);
    public function remove(EntityInterface $entity);
}
