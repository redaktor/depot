<?php

namespace Depot\Core\Model\Entity;

interface EntityRepositoryInterface
{
    public function findByUri($uri);
}
