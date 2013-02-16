<?php

namespace Depot\Api\Server\Symfony\RequestEntityResolver;

use Depot\Core\Model\Entity\EntityRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class StaticSingleTenantRequestEntityResolver implements RequestEntityResolverInterface
{
    protected $entityRepository;
    protected $entityUri;

    public function __construct(EntityRepositoryInterface $entityRepository, $entityUri)
    {
        $this->entityRepository = $entityRepository;
        $this->entityUri = $entityUri;
    }

    public function resolveEntity(Request $request)
    {
        return $this->entityRepository->findByUri($this->entityUri);
    }
}
