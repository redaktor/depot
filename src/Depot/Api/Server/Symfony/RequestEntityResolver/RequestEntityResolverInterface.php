<?php

namespace Depot\Api\Server\Symfony\RequestEntityResolver;

use Symfony\Component\HttpFoundation\Request;

interface RequestEntityResolverInterface
{
    public function resolveEntity(Request $request);
}
