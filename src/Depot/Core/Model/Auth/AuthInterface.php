<?php

namespace Depot\Core\Model\Auth;

interface AuthInterface
{
    public function macKeyId();
    public function macKey();
    public function macAlgorithm();
    public function isAnonymous();
}
