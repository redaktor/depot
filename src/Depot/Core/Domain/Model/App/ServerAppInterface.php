<?php

namespace Depot\Core\Domain\Model\App;

interface ServerAppInterface
{
    public function id();
    public function app();
    public function auth();
    public function authorizations();
    public function createdAt();
}
