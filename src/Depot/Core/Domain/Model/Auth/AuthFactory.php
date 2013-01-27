<?php

namespace Depot\Core\Domain\Model\Auth;

use Depot\Core\Domain\Service\Secret;

class AuthFactory
{
    protected $secretGenerator;

    public function __construct(Secret\SecretGeneratorInterface $secretGenerator = null)
    {
        $this->secretGenerator = $secretGenerator ?: new Secret\UuidSecretGenerator;
    }

    public function generate()
    {
        return new Auth(
            $this->secretGenerator->generate(),
            $this->secretGenerator->generate()
        );
    }

    public function anonymous()
    {
        return new Auth(0, 0, null, true);
    }

    public function create($macKeyId, $macKey, $macAlgorithm = null)
    {
        return new Auth($macKeyId, $macKey, $macAlgorithm);
    }
}
