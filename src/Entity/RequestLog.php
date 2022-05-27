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
    
    /** @var integer */
    private $responseStatusCode;

    /** @var string */
    private $responseStatusText;
    
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

    public function getObfuscatedParameters()
    {
        $re = '/"(\w*password\w*)":{"first":"(\w*)","second":"(\w*)"}/mi';
        $subst = '"$1":{"first":"***","second":"***"}';
        $result = preg_replace($re, $subst, $this->parameters);
        return $result;
    }

    public function getParametersHtml()
    {
        if($this->parameters)
        {
            if(substr($this->parameters,0,1)=='{')
            {
                return '<a href="#params-'.$this->id.'" title="'.$this->pathInfo.'" data-emodal="inline"><i class="fas fa-info-circle"></i></a><div class="d-none"><pre id="params-'.$this->id.'" class="p-5">'.json_encode(json_decode($this->getObfuscatedParameters()), JSON_PRETTY_PRINT).'</pre></div>';
            }
            else
            {
                return '<span data-toggle="tooltip" title="'.$this->parameters.'"><i class="fas fa-info-circle"></i></span>';
            }
        }
        return $this->parameters;
    }

    public function getResponseStatusCodeHtml()
    {
        $class = 'badge-default';
        if($this->responseStatusCode >= 200 && $this->responseStatusCode < 300) $class = 'badge-success';
        if($this->responseStatusCode >= 300 && $this->responseStatusCode < 400) $class = 'badge-info';
        if($this->responseStatusCode >= 400 && $this->responseStatusCode < 500) $class = 'badge-warning';
        if($this->responseStatusCode >= 500 && $this->responseStatusCode < 600) $class = 'badge-danger';

        return '<span class="badge '.$class.'" data-toggle="tooltip" title="'.$this->responseStatusText.'">'.$this->responseStatusCode.'</span>';
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

    /**
     * @return int
     */
    public function getResponseStatusCode(): ?int
    {
        return $this->responseStatusCode;
    }

    /**
     * @param int $responseStatusCode
     * @return RequestLog
     */
    public function setResponseStatusCode(?int $responseStatusCode): RequestLog
    {
        $this->responseStatusCode = $responseStatusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseStatusText(): ?string
    {
        return $this->responseStatusText;
    }

    /**
     * @param string $responseStatusText
     * @return RequestLog
     */
    public function setResponseStatusText(?string $responseStatusText): RequestLog
    {
        $this->responseStatusText = $responseStatusText;
        return $this;
    }
    

}