<?php

namespace Depot\Core\Domain\Model\Follower;

interface FollowerInterface
{
    public function entity();
    public function followerEntity();
    public function permissions();
    public function licenses();
    public function types();
    public function groups();
    public function auth();
    public function id();
    public function notificationPath();
    public function createdAt();
    public function updatedAt();
}
