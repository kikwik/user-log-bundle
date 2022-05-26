<?php

namespace Kikwik\UserLogBundle\Entity;

class RequestLog
{
    /**************************************/
    /* PROPERTIES                         */
    /**************************************/

    /** @var integer */
    private $id;

    /** @var string */
    private $action;

    /** @var string */
    private $method;

    /** @var string */
    private $pathInfo;

    /** @var string */
    private $data;

    /** @var \DateTime */
    private $createdAt;

    /** @var SessionLog */
    private $sessionLog;

    /**************************************/
    /* CUSTOM METHODS                     */
    /**************************************/

    public function __toString()
    {
        return $this->createdAt->format('[Y-m-d H:i:s]').' '.$this->method.' '.$this->pathInfo.' '.$this->data;
    }

    public function getSessionId()
    {
        return $this->sessionLog->getSessionId();
    }

    public function getDataHtml()
    {
        if($this->data && substr($this->data,0,1)=='{')
        {
            return '<a href="#data-'.$this->id.'" title="'.$this->pathInfo.'" data-emodal="inline"><i class="fas fa-info-circle"></i></a><div class="d-none"><pre id="data-'.$this->id.'">'.json_encode(json_decode($this->data), JSON_PRETTY_PRINT).'</pre></div>';
        }
        return $this->data;
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
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return RequestLog
     */
    public function setAction(string $action): RequestLog
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RequestLog
     */
    public function setMethod(string $method): RequestLog
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathInfo(): string
    {
        return $this->pathInfo;
    }

    /**
     * @param string $pathInfo
     * @return RequestLog
     */
    public function setPathInfo(string $pathInfo): RequestLog
    {
        $this->pathInfo = $pathInfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return RequestLog
     */
    public function setData(string $data): RequestLog
    {
        $this->data = $data;
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
     * @return RequestLog
     */
    public function setCreatedAt(\DateTime $createdAt): RequestLog
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return SessionLog
     */
    public function getSessionLog(): SessionLog
    {
        return $this->sessionLog;
    }

    /**
     * @param SessionLog $sessionLog
     * @return RequestLog
     */
    public function setSessionLog(SessionLog $sessionLog): RequestLog
    {
        $this->sessionLog = $sessionLog;
        return $this;
    }


}