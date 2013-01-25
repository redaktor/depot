<?php

namespace Depot\Core\Domain\Model\App;

interface AuthorizationAttemptInterface
{
    public function registeredApp();
    public function code();
    public function state();
    public function profileTypes();
    public function postTypes();
    public function scopes();
}
