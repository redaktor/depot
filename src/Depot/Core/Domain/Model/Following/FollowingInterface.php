<?php

namespace Depot\Core\Domain\Model\Following;

use Depot\Core\Domain\Model\Auth\AuthInterface;

interface FollowingInterface
{
    public function entity();
    public function followingEntity();
    public function permissions();
    public function licenses();
    public function types();
    public function groups();
    public function updateAuth(AuthInterface $auth, $remoteId, $licenses, $types);
    public function auth();
    public function remoteId();
    public function isConfirmed();
    public function confirm(AuthInterface $auth, $remoteId, $licenses, $types);
    public function createdAt();
    public function updatedAt();
}
