<?php

namespace Depot\Core\Model\Entity;

interface ProfileInterface
{
    public function types();
    public function set(ProfileTypeInterface $type);
    public function remove(ProfileTypeInterface $type);
    public function find($uri);
}
