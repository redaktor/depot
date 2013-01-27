<?php

namespace Depot\Api\Server\Symfony\Controller\App;

use Depot\Api\Server\Symfony\ResponseFactory;
use Depot\Core\Domain\Model;
use Depot\Core\Domain\Service\Json\JsonRendererInterface;
use Symfony\Component\HttpFoundation\Request;

class DetailController
{
    protected $jsonRenderer;
    protected $serverAppRepository;
    protected $responseFactory;

    public function __construct(
        JsonRendererInterface $jsonRenderer,
        Model\App\ServerAppRepositoryInterface $serverAppRepository,
        ResponseFactory $responseFactory = null
    )
    {
        $this->jsonRenderer = $jsonRenderer;
        $this->serverAppRepository = $serverAppRepository;
        $this->responseFactory = $responseFactory ?: new ResponseFactory;
    }

    public function detailAction($identityOrEntityUri)
    {
        $server = $this->serverAppRepository->findByIdentityOrEntityUri($identityOrEntityUri);

        return $this->responseFactory->createTentJsonResponse(
            $this->jsonRenderer->render(
                Model\App\AppRegistrationResponse::createFromServerApp(
                    $serverApp
                )
            )
        );
    }
}
