<?php

namespace Depot\Core\Domain\Model\App;

class AuthorizationAuth implements AuthorizationAuthInterface
{
    protected $registeredApp;
    protected $authorization;
    protected $auth;
    protected $tokenType;
    protected $refreshToken;
    protected $expiresAt;

    public function __construct(RegisteredAppInterface $registeredApp, /*AuthorizationInterface $authorization, */ AuthInterface $auth, $tokenType, $refreshToken, $expiresAt)
    {
        $this->registeredApp = $registeredApp;
        //$this->authorization = $authorization;
        $this->auth = $auth;
        $this->tokenType = $tokenType;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = $expiresAt;
    }

    public function registeredApp()
    {
        return $this->registeredApp;
    }

    public function authorization()
    {
        return $this->authorization;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function tokenType()
    {
        return $this->tokenType;
    }

    public function refreshToken()
    {
        return $this->refreshToken;
    }

    public function expiresAt()
    {
        return $this->expiresAt;
    }
}
