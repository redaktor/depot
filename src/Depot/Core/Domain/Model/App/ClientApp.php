<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

class ClientApp implements ClientAppInterface
{
    protected $id;
    protected $app;
    protected $auth;
    protected $createdAt;

    public function __construct($id, $app, AuthInterface $auth, $createdAt = null)
    {
        $this->id = $id;
        $this->app = $app;
        $this->auth = $auth;
        $this->createdAt = $createdAt;
    }

    public function id()
    {
        return $this->id;
    }

    public function app()
    {
        return $this->app;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }
}
