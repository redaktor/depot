<?php

namespace Depot\Core\Domain\Model\App;

class AppRegistrationResponse
{
    protected $id;
    protected $auth;
    protected $minimumAuthorizations;
    protected $createdAt;

    public function __construct($id, $app, array $minimumAuthorizations, $createdAt = null)
    {
        $this->id = $id;
        $this->app = $app;
        $this->auth = $auth;
        $this->minimumAuthorizations = $minimumAuthorizations;
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

    public function minimumAuthorizations()
    {
        return $this->minimumAuthorizations;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }
}
