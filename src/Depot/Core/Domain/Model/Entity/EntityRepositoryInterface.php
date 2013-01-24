<?php

namespace Depot\Core\Domain\Model\Entity;

interface EntityRepositoryInterface
{
    public function findByUri($uri);
}
