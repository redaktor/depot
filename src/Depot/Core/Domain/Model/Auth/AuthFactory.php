<?php

namespace Depot\Core\Domain\Model\Auth;

class AuthFactory
{
    public function generate()
    {
        // generate a new Auth from random information
    }

    public function anonymous()
    {
        // return a fixed anonymous auth
        return new Auth(0, 0, 0, true);
    }

    public function create($macKeyId, $macKey, $macAlgorithm)
    {
        return new Auth($macKeyId, $macKey, $macAlgorithm);
    }
}
