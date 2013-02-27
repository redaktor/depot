<?php

namespace Depot\Api\Server\Symfony\Controller\Apps;

use Depot\Api\Dto;
use Depot\Core\Service\Serializer\SerializerInterface;
use Depot\Core\Service\ServerApp\ServerAppCreatorInterface;

class RegistrationController
{
    protected $serializer;
    protected $serverAppCreator;

    public function __construct(
        SerializerInterface $serializer,
        ServerAppCreatorInterface $serverAppCreator
    )
    {
        $this->serializer = $serializer;
        $this->serverAppCreator = $serverAppCreator;
    }

    public function action(Request $request)
    {
        $app = $this->serializer->deserialize($request->getContent());

        return Dto\App\AppCreationResponse::createFromServerApp(
            $this->serverAppCreator->createServerApp($app)
        );
    }
}
