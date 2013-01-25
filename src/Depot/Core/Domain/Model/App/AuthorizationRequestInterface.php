<?php

namespace Depot\Core\Domain\Model\App;

interface AuthorizationRequestInterface
{
    public function state();
    public function authorizationUrl();
}
