<?php

namespace Depot\Core\Service\Random;

interface ByteGeneratorInterface
{
    public function generateBytes($n = null);
    public function supported();
}
