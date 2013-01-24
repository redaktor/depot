<?php

namespace Depot\Core\Domain\Model\Auth;

class Auth implements AuthInterface
{
    protected $macKeyId;
    protected $macKey;
    protected $macAlgorithm;
    protected $isAnonymous;

    public function __construct($macKeyId, $macKey, $macAlgorithm, $isAnonymous = false)
    {
        $this->macKeyId = $macKeyId;
        $this->macKey = $macKey;
        $this->macAlgorithm = $macAlgorithm;
        $this->isAnonymous = $isAnonymous;
    }

    public function macKeyId()
    {
        return $this->macKeyId;
    }

    public function macKey()
    {
        return $this->macKey;
    }

    public function macAlgorithm()
    {
        return $this->macAlgorithm;
    }

    public function isAnonymous()
    {
        return $this->isAnonymous;
    }
}
