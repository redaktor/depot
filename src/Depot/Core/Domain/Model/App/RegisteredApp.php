<?php

namespace Depot\Core\Domain\Model\App;

class RegisteredApp extends App implements RegisteredAppInterface
{
    protected $id;
    protected $authorizations;
    protected $createdAt;

    public function __construct($name, $description, $url, $icon, array $redirectUris, array $scopes, $id, array $authorizations = null, $createdAt = null)
    {
        parent::__construct($name, $description, $url, $icon, $redirectUris, $scopes);
        $this->id = $id;
        $this->authorizations = $authorizations;
        $this->createdAt = $createdAt;
    }

    public function id()
    {
        return $this->id;
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
