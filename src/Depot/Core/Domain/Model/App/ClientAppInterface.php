<?php

namespace Depot\Core\Domain\Model\App;

interface ClientAppInterface
{
    public function id();
    public function app();
    public function auth();
    public function createdAt();
}
