<?php

namespace Depot\Core\Domain\Model\App;

interface AuthorizationInterface
{
    public function notificationUrl();
    public function id();
    public function profileTypes();
    public function postTypes();
    public function scopes();
}
