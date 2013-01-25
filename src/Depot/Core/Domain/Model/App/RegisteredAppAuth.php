<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

class RegisteredAppAuth implements RegisteredAppAuthInterface
{
    protected $registeredApp;
    protected $auth;

    public function __construct(RegisteredAppInterface $registeredApp, AuthInterface $auth)
    {
        $this->registeredApp = $registeredApp;
        $this->auth = $auth;
    }

    public function registeredApp()
    {
        return $this->registeredApp;
    }

    public function auth()
    {
        return $this->auth;
    }
}
