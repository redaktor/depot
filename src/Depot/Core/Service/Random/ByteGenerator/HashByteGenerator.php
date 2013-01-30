<?php

namespace Depot\Core\Service\Random\ByteGenerator;

use Depot\Core\Service\Random\ByteGeneratorInterface;

class HashByteGenerator implements ByteGeneratorInterface
{
    protected $algo;

    public function __construct(string $algo = null)
    {
        if (null === $algo) {
            $this->algo = 'sha256';
        }
    }

    public function generateBytes($n = null)
    {
        $v = '';
        while (strlen($v) < $n) {
            $v .= hash($this->algo, uniqid(mt_rand(), true), true);
        }

        return substr($v, 0, $n);
    }

    public function supported()
    {
        return true;
    }
}
