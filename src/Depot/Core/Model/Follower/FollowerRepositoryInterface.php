<?php

namespace Depot\Core\Model\Follower;

use Depot\Core\Model\Entity\EntityInterface;

interface FollowerRepositoryInterface
{
    public function find(EntityInterface $entity, EntityInterface $followerEntity);
    public function findByUri(EntityInterface $entity, $uri);
    public function findById(EntityInterface $entity, $id);
    public function findList(EntityInterface $entity, Criteria $criteria = null);
    public function store(FollowingInterface $following);
    public function remove(FollowingInterface $following);
}
