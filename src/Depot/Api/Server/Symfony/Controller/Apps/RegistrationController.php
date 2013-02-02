<?php

namespace Depot\Api\Server\Symfony\Controller\Apps;

use Depot\Api\Server\Symfony\ResponseFactory;
use Depot\Core\Model;
use Depot\Core\Service\Json\JsonRendererInterface;
use Depot\Core\Service\ServerApp\ServerAppCreator;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController
{
    protected $jsonRenderer;
    protected $session;
    protected $appFactory;
    protected $createServerAppService;
    protected $responseFactory;

    public function __construct(
        JsonRendererInterface $jsonRenderer,
        Model\SessionInterface $session,
        Model\App\AppFactory $appFactory,
        ServerAppCreator $serverAppCreator,
        ResponseFactory $responseFactory = null
    )
    {
        $this->jsonRenderer = $jsonRenderer;
        $this->session = $session;
        $this->appFactory = $appFactory;
        $this->serverAppCreator = $serverAppCreator;
        $this->responseFactory = $responseFactory ?: new ResponseFactory;
    }

    public function registerAction(Request $request)
    {
        $app = $this->appFactory->createFromJsonString($request->getContent());

        $serverApp = $this->serverAppCreator->create($app);

        $this->session->store($serverApp)->flush();

        return $this->responseFactory->createTentJsonResponse(
            $this->jsonRenderer->render(
                new Model\App\AppRegistrationCreationResponse(
                    $serverApp->id(),
                    $serverApp->app(),
                    $serverApp->auth(),
                    $serverApp->minimumAuthorizations(),
                    $serverApp->createdAt()
                )
            )
        );
    }
}
