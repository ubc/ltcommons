<?php
/**
 * Created by PhpStorm.
 * User: compass
 * Date: 2014-11-26
 * Time: 2:04 PM
 */

namespace UBC\SISAPI\Service;

use UBC\SISAPI\Authentication\AuthModule;
use UBC\SISAPI\HttpClient\HttpClient;
use UBC\SISAPI\Serializer\Serializer;

abstract class BaseService
{
    protected $config;
    protected $client;
    protected $serializer;
    protected $auth;
    protected $baseUrl;
    protected $auth_username;
    protected $auth_password;
    protected $auth_token;

    protected $response;
    protected $request;

    public function __construct(Config $config, HttpClient $client, Serializer $serializer, AuthModule $auth)
    {
        $this->config = $config;
        $this->client = $client;
        $this->serializer = $serializer;
        $this->auth = $auth;
    }

    public function get($uri)
    {
        $headers = $this->auth->getHeader();
        $this->response = $this->client->get($this->config->getBaseUrl() . $uri, ['headers' => $headers]);
        return $this->response;
    }

    /**
     * Proxy method to get the HTTP status code from client
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->client->getResponse()->getStatusCode();
    }

    public function getResponse()
    {
        return $this->response;
    }
} 