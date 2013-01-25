<?php

namespace Depot\Core\Domain\Model\App;

class AuthorizationRequest implements AuthorizationRequestInterface
{
    protected $state;
    protected $authorizationUrl;

    public function __construct($state, $authorizationUrl)
    {
        $this->state = $state;
        $this->authorizationUrl = $authorizationUrl;
    }

    public function state()
    {
        return $this->state;
    }

    public function authorizationUrl()
    {
        return $this->authorizationUrl;
    }
}
