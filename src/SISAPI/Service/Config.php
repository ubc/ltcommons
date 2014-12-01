<?php
namespace UBC\SISAPI\Service;


class Config {
    private $baseUrl;
    private $authUsername;
    private $authPassword;
    private $authToken;

    public function __construct($baseUrl = null, $username = null, $password = null)
    {
        $this->baseUrl = $baseUrl;
        $this->authUsername = $username;
        $this->authPassword = $password;
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->authPassword;
    }

    /**
     * @param mixed $authPassword
     */
    public function setAuthPassword($authPassword)
    {
        $this->authPassword = $authPassword;
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @param mixed $authToken
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @return mixed
     */
    public function getAuthUsername()
    {
        return $this->authUsername;
    }

    /**
     * @param mixed $authUsername
     */
    public function setAuthUsername($authUsername)
    {
        $this->authUsername = $authUsername;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }


} 