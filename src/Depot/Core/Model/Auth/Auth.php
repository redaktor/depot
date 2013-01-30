<?php

namespace Depot\Core\Model\Auth;

class Auth implements AuthInterface
{
    protected $macKeyId;
    protected $macKey;
    protected $macAlgorithm;
    protected $isAnonymous;

    public function __construct($macKeyId, $macKey, $macAlgorithm = null, $isAnonymous = false)
    {
        $this->macKeyId = $macKeyId;
        $this->macKey = $macKey;
        $this->macAlgorithm = $macAlgorithm ?: 'hmac-sha-256';
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
