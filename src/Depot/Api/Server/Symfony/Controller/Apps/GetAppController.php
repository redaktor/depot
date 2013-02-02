<?php

namespace Depot\Api\Server\Symfony\Controller\Apps;

use Depot\Api\Server\Symfony\ResponseFactory;
use Depot\Core\Model;
use Depot\Core\Service\Json\JsonRendererInterface;
use Symfony\Component\HttpFoundation\Request;

class GetAppController
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

    public function action($id)
    {
        $serverApp = $this->serverAppRepository->find($id);

        return $this->responseFactory->createTentJsonResponse(
            $this->jsonRenderer->render(
                Model\App\AppRegistrationResponse::createFromServerApp(
                    $serverApp
                )
            )
        );
    }
}
