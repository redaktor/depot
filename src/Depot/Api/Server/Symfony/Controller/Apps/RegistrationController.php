<?php

namespace Depot\Api\Server\Symfony\Controller\Apps;

use Depot\Api\Dto;
use Depot\Core\Model;
use Depot\Core\Service\Serializer\SerializerInterface;
use Depot\Core\Service\ServerAppCreator\ServerAppCreatorInterface;

class RegistrationController
{
    public function __construct(
        SerializerInterface $serializer,
        Model\SessionInterface $session,
        ServerAppCreatorInterface $serverAppCreator
    )
    {
        $this->serializer = $serializer;
        $this->session = $session;
        $this->serverAppCreator = $serverAppCreator;
    }

    public function action(Request $request)
    {
        $app = $this->serializer->deserialize($request->getContent());

        $serverAppCreator = $this->serverAppCreator;

        return $this->session->transactional(function() use ($serverAppCreator, $app) {
            $serverApp = $this->serverAppCreator->create($app);

            return Dto\App\AppCreationResponse::createFromServerApp($serverApp);
        });
    }
}
