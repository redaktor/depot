<?php

namespace Depot\Core\Model\Following;

use Depot\Core\Model\Entity\EntityInterface;

interface FollowingRepositoryInterface
{
    public function find(EntityInterface $entity, EntityInterface $followingEntity);
    public function findByUri(EntityInterface $entity, $uri);
    public function findById(EntityInterface $entity, $id);
    public function findList(EntityInterface $entity, Criteria $criteria = null);
    public function store(FollowingInterface $following);
    public function remove(FollowingInterface $following);
}
