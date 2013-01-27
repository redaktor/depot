<?php

namespace Depot\Core\Domain\Model\App;

interface ServerAppRepositoryInterface
{
    public function find($id);
    public function findByIdentityOrEntityUri($identityOrEntityUri);
}
