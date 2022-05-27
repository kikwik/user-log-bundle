<?php

namespace Kikwik\UserLogBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class SessionLog
{
    /**************************************/
    /* PROPERTIES                         */
    /**************************************/

    /** @var integer */
    private $id;

    /** @var string */
    private $sessionId;

    /** @var UserInterface */
    private $user;

    /** @var string */
    private $userIdentifier;

    /** @var string */
    private $remoteIp;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var string */
    private $duration;

    /** @var Collection */
    private $requestLogs;

    /** @var integer */
    private $requestLogsCount = 0;

    public function __construct()
    {
        $this->requestLogs = new ArrayCollection();
    }

    /**************************************/
    /* CUSTOM METHODS                     */
    /**************************************/

    public function __toString()
    {
        return $this->getUser().' - '.$this->sessionId;
    }

    public function setData(UserInterface $user, string $sessionId, string $remoteIp)
    {
        $this->user = $user;
        $this->userIdentifier = $user->getUserIdentifier();
        $this->sessionId = $sessionId;
        $this->remoteIp = $remoteIp;
        if(!$this->createdAt)
        {
            $this->createdAt = new \DateTime();
            $this->updatedAt = new \DateTime();
            $this->duration = '00:00:00';
            $this->requestLogsCount = 1;
        }
        else
        {
            $this->updatedAt = new \DateTime();
            $diff = $this->updatedAt->diff($this->createdAt);
            $this->duration = $diff->format('%H:%I:%S');
            $this->requestLogsCount++;
        }
    }


    /**************************************/
    /* GETTERS                            */
    /**************************************/


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @return string
     */
    public function getRemoteIp(): string
    {
        return $this->remoteIp;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return Collection
     */
    public function getRequestLogs()
    {
        return $this->requestLogs;
    }

    /**
     * @return int
     */
    public function getRequestLogsCount(): int
    {
        return $this->requestLogsCount;
    }


}