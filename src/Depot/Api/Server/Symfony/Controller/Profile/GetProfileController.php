<?php

namespace Depot\Api\Server\Symfony\Controller\Profile;

use Depot\Core\Model;
use Symfony\Component\HttpFoundation\Request;

class GetProfileController
{
    protected $entityRepository;

    public function __construct(Model\Entity\EntityRepositoryInterface $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function action(Request $request)
    {
        $entityUri = $request->attributes->get('depot.entity');

        return $this->entityRepository->findByUri($entityUri);
    }
}
