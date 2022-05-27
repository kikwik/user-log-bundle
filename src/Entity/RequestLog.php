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
    private $sessionLogIdentifier;

    /** @var string */
    private $controller;

    /** @var string */
    private $method;

    /** @var string */
    private $pathInfo;

    /** @var string */
    private $parameters;

    /** @var \DateTime */
    private $createdAt;

    /** @var SessionLog */
    private $sessionLog;

    /**************************************/
    /* CUSTOM METHODS                     */
    /**************************************/

    public function __toString()
    {
        return $this->createdAt->format('[Y-m-d H:i:s]').' '.$this->method.' '.$this->pathInfo.' '.$this->parameters;
    }

    public function setData(SessionLog $sessionLog, string $controller, string $method, string $pathInfo, string $parameters)
    {
        $this->sessionLog = $sessionLog;
        $this->sessionLogIdentifier = $sessionLog->__toString();
        $this->controller = $controller;
        $this->method = $method;
        $this->pathInfo = $pathInfo;
        $this->parameters = $parameters;
        $this->createdAt = new \DateTime();
    }

    public function getMethodAndControllerHtml()
    {
        return '<span data-toggle="tooltip" title="'.$this->controller.'">'.$this->method.'</span>';
    }

    public function getParametersHtml()
    {
        if($this->parameters)
        {
            if(substr($this->parameters,0,1)=='{')
            {
                return '<a href="#params-'.$this->id.'" title="'.$this->pathInfo.'" data-emodal="inline"><i class="fas fa-info-circle"></i></a><div class="d-none"><pre id="params-'.$this->id.'" class="p-5">'.json_encode(json_decode($this->parameters), JSON_PRETTY_PRINT).'</pre></div>';
            }
            else
            {
                return '<span data-toggle="tooltip" title="'.$this->parameters.'"><i class="fas fa-info-circle"></i></span>';
            }
        }
        return $this->parameters;
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
    public function getSessionLogIdentifier(): string
    {
        return $this->sessionLogIdentifier;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPathInfo(): string
    {
        return $this->pathInfo;
    }

    /**
     * @return string
     */
    public function getParameters(): string
    {
        return $this->parameters;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return SessionLog
     */
    public function getSessionLog(): SessionLog
    {
        return $this->sessionLog;
    }



}