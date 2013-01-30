<?php

namespace Depot\Core\Service\Secret;

use Depot\Core\Service\Uuid\UuidGenerator;

class UuidSecretGenerator implements SecretGeneratorInterface
{
    protected $uuidGenerator;

    public function __construct(UuidGenerator $uuidGenerator = null)
    {
        $this->uuidGenerator = $uuidGenerator ?: new UuidGenerator;
    }

    public function generateSecret()
    {
        return $this->uuidGenerator->generateUuidVersion4();
    }
}
