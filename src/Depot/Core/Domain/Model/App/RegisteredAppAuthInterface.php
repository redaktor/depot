<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

interface RegisteredAppAuthInterface
{
    public function registeredApp();
    public function auth();
}
