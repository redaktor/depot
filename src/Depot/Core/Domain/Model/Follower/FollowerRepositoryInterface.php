<?php

namespace Depot\Core\Domain\Model\Follower;

use Depot\Core\Domain\Model\Entity\EntityInterface;

interface FollowerRepositoryInterface
{
    public function find(EntityInterface $entity, EntityInterface $followerEntity);
    public function findByUri(EntityInterface $entity, $uri);
    public function findById(EntityInterface $entity, $id);
    public function findList(EntityInterface $entity, Criteria $criteria = null);
    public function store(FollowingInterface $following);
    public function remove(FollowingInterface $following);
}
