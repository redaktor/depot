<?php

namespace Depot\Core\Model\App;

interface ServerAppRepositoryInterface
{
    public function find($id);
    public function findByIdentityOrEntityUri($identityOrEntityUri);
}
