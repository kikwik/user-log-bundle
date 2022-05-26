<?php

namespace Kikwik\UserLogBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class UserLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;


    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'logRequest'
        ];
    }

    public function logRequest(ResponseEvent $event)
    {
        if($event->isMainRequest())
        {
            if($user = $this->security->getUser())
            {
                $sessionId = $event->getRequest()->getSession()->getId();
                $userIp =  $event->getRequest()->getClientIp();
                $action = $event->getRequest()->attributes->get('_controller');
                $method =  $event->getRequest()->getMethod();
                $pathInfo = $event->getRequest()->getPathInfo();
                if($event->getRequest()->request && $method=='POST'){
                    $data = json_encode($event->getRequest()->request->all());
                }else{
                    $data = urldecode($event->getRequest()->getQueryString());
                }
                $responseStatusCode = $event->getResponse()->getStatusCode();
                
                //TODO: save these log data:
                dump($user->getUserIdentifier(), $sessionId, $userIp, $action, $method, $pathInfo, $data, $responseStatusCode);
            }
        }
    }
}