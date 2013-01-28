<?php

namespace Depot\Core\Domain\Service\Random;

interface RandomInterface
{
    public function generateBytes($n = null);
    public function generateUrlSafeBase64($n = null);
}
