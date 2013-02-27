<?php

namespace Depot\Core\Service\ServerApp;

use Depot\Core\Model;
use Depot\Core\Services\Identity\IdentityGeneratorInteface;

class ServerAppCreator implements ServerAppCreatorInterface
{
    protected $session;
    protected $authFactory;
    protected $identityGenerator;

    public function __construct(Model\SessionInterface $session, Model\App\AuthFactory $authFactory, IdentityGeneratorInteface $identityGenerator)
    {
        $this->session = $session;
        $this->authFactory = $authFactory;
        $this->identityGenerator = $identityGenerator;
    }

    public function create(Model\App\AppInterface $app)
    {
        $authFactory = $this->authFactory;
        $identityGenerator = $this->identityGenerator;

        return $this->session->transactional(function($session) use ($identityGenerator, $authFactory, $app) {
            $id = $identityGenerator->generateIdentity();
            $auth = $authFactory->generate();

            $serverApp = new Model\App\ServerApp(
                $id,
                $app,
                $auth,
                array()
            );

            $session->persist($serverApp);

            return $serverApp;
        });
    }
}
