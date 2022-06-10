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

    /** @var boolean */
    private $enableLog;

    public function __construct(Security $security, EntityManagerInterface $entityManager, bool $enableLog)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->enableLog = $enableLog;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'logRequest',
            KernelEvents::RESPONSE => 'logResponse',
        ];
    }

    private $requestLog = null;
    public function logRequest(RequestEvent $event)
    {
        if($this->enableLog)
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

                    $this->requestLog = $requestLog;
                }
            }
        }
    }
    
    public function logResponse(ResponseEvent $event)
    {
        if($this->requestLog)
        {
            $this->requestLog->setResponseStatusCode($event->getResponse()->getStatusCode());
            $this->requestLog->setResponseStatusText($event->getResponse()::$statusTexts[$event->getResponse()->getStatusCode()]);
            $this->entityManager->persist($this->requestLog);
            try
            {
                // when an entity is deleted and has the @Gedmo\SoftDeleteable annotation and is related with other objects
                // caling the flush() will throw the error "Multiple non-persisted new entities were found through the given association graph:"
                // in this case we cannot save the response status code
                $this->entityManager->flush();
            }
            catch (\Throwable $e)
            {
                // nothing here
            }
        }
    }
}