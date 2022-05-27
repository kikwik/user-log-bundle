<?php

namespace Kikwik\UserLogBundle\EventSubscriber;


use Doctrine\ORM\EntityManagerInterface;
use Kikwik\UserLogBundle\Entity\RequestLog;
use Kikwik\UserLogBundle\Entity\SessionLog;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class UserLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'logRequest'
        ];
    }

    public function logRequest(RequestEvent $event)
    {
        if($event->isMainRequest())
        {
            if($user = $this->security->getUser())
            {
                // collect log data
                $sessionId = $event->getRequest()->getSession()->getId();
                $remoteIp =  $event->getRequest()->getClientIp();
                $controller = $event->getRequest()->attributes->get('_controller');
                $method =  $event->getRequest()->getMethod();
                $pathInfo = $event->getRequest()->getPathInfo();
                if($event->getRequest()->request && $method=='POST'){
                    $parameters = json_encode($event->getRequest()->request->all());
                }else{
                    $parameters = urldecode($event->getRequest()->getQueryString());
                }

                // save log data
                $sessionLog = $this->entityManager->getRepository(SessionLog::class)->findOneBY(['user'=>$user, 'sessionId'=>$sessionId]);
                if(!$sessionLog)
                {
                    $sessionLog = new SessionLog();
                }
                $sessionLog->setData($user, $sessionId, $remoteIp);

                $requestLog = new RequestLog();
                $requestLog->setData($sessionLog, $controller, $method, $pathInfo, $parameters);

                $this->entityManager->persist($requestLog);
                $this->entityManager->persist($sessionLog);
                $this->entityManager->flush();

            }
        }
    }
}