<?php

namespace Depot\Core\Domain\Model\Entity;

interface ProfileInterface
{
    public function types();
    public function set(ProfileTypeInterface $type);
    public function remove(ProfileTypeInterface $type);
    public function find($uri);
}
