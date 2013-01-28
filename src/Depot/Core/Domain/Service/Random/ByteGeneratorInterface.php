<?php

namespace Depot\Core\Domain\Service\Random;

interface ByteGeneratorInterface
{
    public function generateBytes($n = null);
    public function supported();
}
