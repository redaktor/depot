<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

interface AuthorizationAuthInterface
{
    public function registeredApp();
    public function authorization();
    public function auth();
    public function tokenType();
    public function refreshToken();
    public function expiresAt();
}
