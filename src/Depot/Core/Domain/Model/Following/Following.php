<?php

namespace Depot\Core\Domain\Model\Following;

use Depot\Core\Domain\Model\Auth\AuthInterface;
use Depot\Core\Domain\Model\Entity\EntityInterface;

class Following implements FollowingInterface
{
    protected $entity;
    protected $permissions;
    protected $licenses;
    protected $types;
    protected $groups;
    protected $auth;
    protected $remoteId;
    protected $createdAt;
    protected $updatedAt;

    public function __construct(EntityInterface $entity, EntityInterface $followingEntity, array $permissions, array $licenses, array $types, array $groups = null, AuthInterface $auth = null, $remoteId = null, $createdAt = null, $updatedAt = null)
    {
        $this->entity = $entity;
        $this->followingEntity = $followingEntity;
        $this->permissions = $permissions;
        $this->licenses = $licenses;
        $this->types = $types;
        $this->groups = $groups;
        $this->auth = $auth;
        $this->remoteId = $remoteId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt ?: $createdAt;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function followingEntity()
    {
        return $this->followingEntity;
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

    public function updateAuth(AuthInterface $auth, $remoteId, $licenses, $types)
    {
        $this->auth = $auth;
        $this->remoteId = $remoteId;
        $this->licenses = $licenses;
        $this->types = $types;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function remoteId()
    {
        return $this->remoteId;
    }

    public function isConfirmed()
    {
        return $this->isConfirmed;
    }

    public function confirm(AuthInterface $auth, $remoteId, array $licenses, array $types)
    {
        $this->updateAuth($auth, $remoteId, $licenses, $types);
        $this->isconfirmed = true;
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
