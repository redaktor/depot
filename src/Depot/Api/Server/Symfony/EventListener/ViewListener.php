<?php

namespace Depot\Api\Server\Symfony\EventListener;

use Depot\Api\Server\Symfony\View\ViewInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ViewListener implements EventSubscriberInterface
{
    protected $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $response = $event->getControllerResult();
        if (null !== $response = $this->view->render($response)) {
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::VIEW => array('onKernelView', -10),
        );
    }
}
