<?php

namespace Depot\Api\Server\Symfony\EventListener;

use Depot\Core\Model\Entity\EntityRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EntityListener implements EventSubscriberInterface
{
    protected $entityRepository;

    public function __construct(EntityRepositoryInterface $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getController();

        if (is_array($controller)) {
            $r = new \ReflectionMethod($controller[0], $controller[1]);
        } elseif (is_object($controller) && !$controller instanceof \Closure) {
            $r = new \ReflectionObject($controller);
            $r = $r->getMethod('__invoke');
        } else {
            $r = new \ReflectionFunction($controller);
        }

        foreach ($r->getParameters() as $param) {
            if ($param->getClass() && $param->getClass()->implementsInterface('Depot\Core\Model\Entity\EntityInterface')) {
                $entity = $this->entityRepository->findByUri(
                    $request->attributes->get('depot.entity')
                );
                $request->attributes->set($param->getName(), $entity);
            } elseif (!$request->attributes->has('entity')) {
                $entity = $this->entityRepository->findByUri(
                    $request->attributes->get('depot.entity')
                );
                $request->attributes->set('entity', $entity);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController'),
        );
    }
}
