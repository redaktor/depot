<?php

namespace Depot\Core\Model\Entity;

interface ProfileInterface
{
    const TYPE_CORE = 'https://tent.io/types/info/core/v0.1.0';

    public function types();
    public function set(ProfileInfoInterface $type);
    public function remove(ProfileInfoInterface $type);
    public function find($uri);
}
