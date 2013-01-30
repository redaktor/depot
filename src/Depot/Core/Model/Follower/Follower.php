<?php

namespace Depot\Core\Model\Follower;

use Depot\Core\Model\Entity\EntityInterface;

class Follower implements FollowerInterface
{
    protected $entity;
    protected $followerEntity;
    protected $permissions;
    protected $licenses;
    protected $types;
    protected $groups;
    protected $auth;
    protected $notificationPath;
    protected $createdAt;
    protected $updatedAt;

    public function __construct(EntityInterface $entity, EntityInterface $followerEntity, array $permissions, array $licenses, array $types, array $groups, $auth, $notificationPath, $createdAt = null, $updatedAt = null)
    {
        $this->entity = $entity;
        $this->followerEntity = $followerEntity;
        $this->permissions = $permissions;
        $this->licenses = $licenses;
        $this->types = $types;
        $this->groups = $groups;
        $this->auth = $auth;
        $this->notificationPath = $notificationPath;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt ?: $createdAt;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function followerEntity()
    {
        return $this->followerEntity;
    }

    public function permissions()
    {
        return $this->permissions;
    }
    public function licenses()
    {
        return $this->licenses;
    }
    public function types()
    {
        return $this->types;
    }
    public function groups()
    {
        return $this->groups;
    }
    public function auth()
    {
        return $this->auth;
    }
    public function notificationPath()
    {
        return $this->notificationPath;
    }
    public function createdAt()
    {
        return $this->createdAt;
    }
    public function updatedAt()
    {
        return $this->updatedAt;
    }
}
