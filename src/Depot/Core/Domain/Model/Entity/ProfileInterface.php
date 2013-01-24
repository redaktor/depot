<?php

namespace Depot\Core\Domain\Model\Entity;

interface ProfileInterface
{
    public function typeUris();
    public function set(ProfileTypeInterface $type);
    public function remove(ProfileTypeInterface $type);
    public function find($uri);
}
