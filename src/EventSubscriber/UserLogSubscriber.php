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
                $action = $event->getRequest()->attributes->get('_controller');
                $method =  $event->getRequest()->getMethod();
                $pathInfo = $event->getRequest()->getPathInfo();
                if($event->getRequest()->request && $method=='POST'){
                    $data = json_encode($event->getRequest()->request->all());
                }else{
                    $data = urldecode($event->getRequest()->getQueryString());
                }

                // save log data
                $sessionLog = $this->entityManager->getRepository(SessionLog::class)->findOneBY(['user'=>$user, 'sessionId'=>$sessionId]);
                if(!$sessionLog)
                {
                    $sessionLog = new SessionLog();
                    $sessionLog->setUser($user);
                    $sessionLog->setSessionId($sessionId);
                    $sessionLog->setRemoteIp($remoteIp);
                    $sessionLog->setCreatedAt(new \DateTime());
                }
                $sessionLog->setUpdatedAt(new \DateTime);

                $actionLog = new RequestLog();
                $actionLog->setSessionLog($sessionLog);
                $actionLog->setAction($action);
                $actionLog->setMethod($method);
                $actionLog->setPathInfo($pathInfo);
                $actionLog->setData($data);
                $actionLog->setCreatedAt(new \DateTime());

                $this->entityManager->persist($actionLog);
                $this->entityManager->persist($sessionLog);
                $this->entityManager->flush();

            }
        }
    }
}