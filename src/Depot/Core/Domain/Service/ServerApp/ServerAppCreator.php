<?php

namespace Depot\Core\Domain\Service\ServerApp;

use Depot\Core\Domain\Model;
use Depot\Core\Domain\Services\Identity\IdentityGeneratorInteface;

class ServerAppCreator
{
    public function __construct(Model\App\AuthFactory $authFactory, IdentityGeneratorInteface $identityGenerator)
    {
        $this->authFactory = $authFactory;
        $this->identityGenerator = $identityGenerator;
    }

    public function create(Model\App\AppInterface $app)
    {
        $auth = $this->authFactory->generate();
        $id = $this->identityGenerator->generateIdentity();

        return new Model\App\ServerApp(
            $id,
            $app,
            $auth,
            array()
        );
    }
}
