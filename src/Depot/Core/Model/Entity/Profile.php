<?php

namespace Depot\Core\Model\Entity;

class Profile implements ProfileInterface
{
    protected $types;

    public function types()
    {
        return array_keys($this->types);
    }

    public function set(ProfileTypeInterface $type)
    {
        $this->types[$type->uri()] = $type;
    }

    public function remove(ProfileTypeInterface $type)
    {
        unset($this->types[$type->uri()]);
    }

    public function find($uri)
    {
        return isset($this->types[$uri]) ? $this->types[$uri] : null;
    }
}
