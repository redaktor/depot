<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Api\Server\Symfony\ResponseFactory;
use Depot\Core\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class GetProfileController
{
    protected $serializer;
    protected $entityRepository;
    protected $responseFactory;

    public function __construct(
        SerializerInterface $serializer,
        Model\Entity\EntityRepositoryInterface $entityRepository,
        ResponseFactory $responseFactory = null
    )
    {
        $this->serializer = $serializer;
        $this->entityRepository = $entityRepository;
        $this->responseFactory = $responseFactory ?: new ResponseFactory;
    }

    public function action(Request $request)
    {
        $entityUri = $request->attributes->get('depot.entity');

        $entity = $this->entityRepository->findByUri($entityUri);

        return $this->responseFactory->createTentJsonResponse(
            $this->serializer->serialize($entity, 'json')
        );
    }
}
