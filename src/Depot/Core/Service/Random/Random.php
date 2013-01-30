<?php

namespace Depot\Core\Service\Random;

class Random implements RandomInterface
{
    protected $byteGenerators;

    public function __construct(array $byteGenerators = null)
    {
        $this->byteGenerators = $byteGenerators ?: array(
            new ByteGenerator\OpenSslByteGenerator,
            new ByteGenerator\HashByteGenerator,
        );
    }

    public function generateBytes($n = null)
    {
        foreach ($this->byteGenerators as $idx => $byteGenerator) {
            if ($byteGenerator->supported()) {
                if (null !== $v = $byteGenerator->generateBytes($n)) {
                    return $v;
                }
            }
            unset($this->byteGenerators[$idx]);
        }

        throw new \RuntimeException('No registered generator was able to generate random bytes');
    }

    public function generateUrlSafeBase64($n = null)
    {
        return str_replace(
            array('+', '/', '=', "\n"),
            array('-', '_', '', ''),
            base64_encode($this->generateBytes($n))
        );
    }
}
