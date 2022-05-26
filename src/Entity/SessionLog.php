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

    /** @var string */
    private $remoteIp;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var Collection */
    private $requestLogs;

    /** @var UserInterface */
    private $user;

    public function __construct()
    {
        $this->requestLogs = new ArrayCollection();
    }

    /**************************************/
    /* CUSTOM METHODS                     */
    /**************************************/

    public function __toString()
    {
        return 'Sessione del '.$this->createdAt->format('d/m/Y H:i:s');
    }

    public function getRequestLogsCount()
    {
        return $this->requestLogs->count();
    }

    public function getDuration()
    {
        $diff = $this->updatedAt->diff($this->createdAt);
        return $diff->format('%H:%I:%S');
    }

    /**************************************/
    /* GETTERS & SETTERS                  */
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
     * @param string $sessionId
     * @return SessionLog
     */
    public function setSessionId(string $sessionId): SessionLog
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoteIp(): string
    {
        return $this->remoteIp;
    }

    /**
     * @param string $remoteIp
     * @return SessionLog
     */
    public function setRemoteIp(string $remoteIp): SessionLog
    {
        $this->remoteIp = $remoteIp;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return SessionLog
     */
    public function setCreatedAt(\DateTime $createdAt): SessionLog
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return SessionLog
     */
    public function setUpdatedAt(\DateTime $updatedAt): SessionLog
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return RequestLog[]
     */
    public function getRequestLogs(): Collection
    {
        return $this->requestLogs;
    }

    /**
     * @param RequestLog[] $requestLogs
     * @return SessionLog
     */
    public function setRequestLogs(array $requestLogs): SessionLog
    {
        $this->requestLogs = $requestLogs;
        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return SessionLog
     */
    public function setUser(UserInterface $user): SessionLog
    {
        $this->user = $user;
        return $this;
    }




}