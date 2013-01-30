<?php

namespace Depot\Core\Model\App;

interface ClientAppInterface
{
    public function id();
    public function app();
    public function auth();
    public function createdAt();
}
