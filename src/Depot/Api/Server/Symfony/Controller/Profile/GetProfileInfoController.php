<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Api\Server\Symfony\ResponseFactory;
use Depot\Core\Model;
use Symfony\Component\HttpFoundation\Request;

class GetProfileInfoController
{
    protected $jsonRenderer;
    protected $entityRepository;
    protected $responseFactory;

    public function __construct(
        JsonRendererInterface $jsonRenderer,
        Model\Entity\EntityRepositoryInterface $entityRepository,
        ResponseFactory $responseFactory = null
    )
    {
        $this->jsonRenderer = $jsonRenderer;
        $this->entityRepository = $entityRepository;
        $this->responseFactory = $responseFactory ?: new ResponseFactory;
    }

    public function action(Request $request, $type)
    {
        $entityUri = $request->attributes->get('depot.entity');

        $entity = $this->entityRepository->findByUri($entityUri);

        return $this->responseFactory->createTentJsonResponse(
            $this->jsonRenderer->render($entity->findProfileInfo($type))
        );
    }
}
