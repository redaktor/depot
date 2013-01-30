<?php

namespace Depot\Core\Service\Random\ByteGenerator;

use Depot\Core\Service\Random\ByteGeneratorInterface;

class OpenSslByteGenerator implements ByteGeneratorInterface
{
    protected $supported = null;

    public function generateBytes($n = null)
    {
        $v = openssl_random_pseudo_bytes($n, $strong);
        if (true === $strong) {
            return $v;
        }

        // Let's assume we dont want come back here again.
        $this->supported = false;

        return null;
    }

    public function supported()
    {
        if (null !== $this->supported) {
            return $this->supported;
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            if (version_compare(PHP_VERSION, '5.3.7') >= 0 || (PHP_OS & "\xDF\xDF\xDF") !== 'WIN') {
                return $this->supported = true;
            }
        }

        return $this->supported = false;
    }
}
