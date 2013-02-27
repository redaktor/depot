<?php

namespace Depot\Core\Infrastructure\Persistence\Doctrine\Orm;

use Depot\Core\Model\SessionInterface;
use Doctrine\ORM\EntityManager;

class Session implements SessionInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist($object)
    {
        $this->entityManager->persist($object);

        return $this;
    }

    public function remove($object)
    {
        $this->entityManager->remove($object);

        return $this;
    }

    public function merge($object)
    {
        return $this->entityManager->merge($object);
    }

    public function clear($objectName = null)
    {
        $this->entityManager->clear($objectName);

        return $this;
    }

    public function detach($object)
    {
        $this->entityManager->detach($object);

        return $this;
    }

    public function refresh($object)
    {
        $this->entityManager->refresh($object);

        return $this;
    }

    public function flush()
    {
        $this->entityManager->flush();

        return $this;
    }

    public function transactional($func)
    {
        $session = $this;

        return $this->entityManager->transactional(function() use ($session, $func) {
            return call_user_func_array($func, $session);
        });
    }
}
