<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

interface RegisteredAppInterface extends AppInterface
{
    public function id();
    public function createdAt();
    public function authorizations();
}
