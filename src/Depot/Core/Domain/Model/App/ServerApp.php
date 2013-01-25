<?php

namespace Depot\Core\Domain\Model\App;

use Depot\Core\Domain\Model\Auth\AuthInterface;

class ServerApp implements ServerAppInterface
{
    protected $id;
    protected $app;
    protected $auth;
    protected $minimumAuthorizations;
    protected $createdAt;

    public function __construct($id, $app, AuthInterface $auth, array $authorizations, $createdAt = null)
    {
        $this->id = $id;
        $this->app = $app;
        $this->auth = $auth;
        $this->authorizations = $authorizations;
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

    public function authorizations()
    {
        return $this->authorizations;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }
}
