<?php

namespace Depot\Core\Domain\Model\App;

class App implements AppInterface
{
    protected $name;
    protected $description;
    protected $url;
    protected $icon;
    protected $redirectUris;
    protected $scopes;

    public function __construct($name, $description, $url, $icon, array $redirectUris, array $scopes)
    {
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->icon = $icon;
        $this->redirectUris = $redirectUris;
        $this->scopes = $scopes;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function url()
    {
        return $this->url;
    }

    public function icon()
    {
        return $this->icon;
    }

    public function redirectUris()
    {
        return $this->redirectUris;
    }

    public function scopes()
    {
        return $this->scopes;
    }

    public function removeScope($scope)
    {
        if (isset($this->scopes[$scope])) {
            unset($this->scopes[$scope]);
        }
    }

    public function setScope($scope, $value)
    {
        $this->scopes[$scope] = $value;
    }
}
