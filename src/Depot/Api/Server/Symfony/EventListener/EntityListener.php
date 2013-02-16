<?php

namespace Depot\Api\Server\Symfony\EventListener;

use Depot\Api\Server\Symfony\RequestEntityResolver\RequestEntityResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EntityListener implements EventSubscriberInterface
{
    protected $requestEntityResolver;

    public function __construct(RequestEntityResolverInterface $requestEntityResolver)
    {
        $this->requestEntityResolver = $requestEntityResolver;
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

        $attributes = array();

        foreach ($r->getParameters() as $param) {
            if ($param->getClass() && $param->getClass()->implementsInterface('Depot\Core\Model\Entity\EntityInterface')) {
                $attributes[$param->getName()] = true;
            } elseif ('entity' == $param->getName() && !$request->attributes->has('entity')) {
                $attributes[$param->getName()] = true;
            }
        }

        if ($attributes) {
            $entity = $this->requestEntityResolver->resolveEntity($request);
            foreach (array_keys($attributes) as $attribute) {
                $request->attributes->set($attribute, $entity);
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
