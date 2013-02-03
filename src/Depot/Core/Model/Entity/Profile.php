<?php

namespace Depot\Core\Model\Entity;

class Profile implements ProfileInterface
{
    protected $types;

    public function types()
    {
        return array_keys($this->types);
    }

    public function set(ProfileInfoInterface $type)
    {
        $this->types[$type->uri()] = $type;
    }

    public function remove(ProfileInfoInterface $type)
    {
        if (ProfileInterface::TYPE_CORE === $profileInfo->uri()) {
            throw new \RuntimeException("Cannot remove core profile type");
        }

        unset($this->types[$type->uri()]);
    }

    public function find($uri)
    {
        return isset($this->types[$uri]) ? $this->types[$uri] : null;
    }

    public function findCoreEntityUri()
    {
        $content = $this->find(ProfileInterface::TYPE_CORE)->content();

        return $content['entity'];
    }
}
