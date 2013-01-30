<?php

namespace Depot\Core\Model\App;

interface ServerAppInterface
{
    public function id();
    public function app();
    public function auth();
    public function authorizations();
    public function createdAt();
}
