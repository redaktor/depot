<?php

namespace Depot\Core\Domain\Model\Entity;

class Entity implements EntityInterface
{
    protected $uri;
    protected $profile;

    public function __construct($uri, ProfileInterface $profile)
    {
        $this->uri = $uri;
        $this->profile = $profile;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function profile()
    {
        return $this->profile;
    }
}
