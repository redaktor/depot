<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

class ClientAuthorizationResponse
{
    protected $clientApp;
    protected $auth;
    protected $tokenType;
    protected $refreshToken;
    protected $expiresAt;

    public function __construct(ClientAppInterface $clientApp, AuthInterface $auth, $tokenType, $refreshToken, $expiresAt = null)
    {
        $this->clientApp = $clientApp;
        $this->auth = $auth;
        $this->tokenType = $tokenType;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = $expiresAt;
    }

    public function clientApp()
    {
        return $this->clientApp;
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
