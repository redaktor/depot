<?php

namespace Depot\Core\Domain\Model\Auth;

class AuthFactory
{
    public static function generate()
    {
        // generate a new Auth from random information
    }

    public static function anonymous()
    {
        // return a fixed anonymous auth
        return new Auth(0, 0, null, true);
    }

    public static function create($macKeyId, $macKey, $macAlgorithm = null)
    {
        return new Auth($macKeyId, $macKey, $macAlgorithm);
    }
}
