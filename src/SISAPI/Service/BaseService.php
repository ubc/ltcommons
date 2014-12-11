<?php
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
        $url = $uri;
        if ((substr($uri, 0, 7) != 'http://') && (substr($uri, 0, 8) != 'https://')) {
            // the current link is an "relative" URL
            $url = $this->config->getBaseUrl() . $uri;
        }
        $headers = $this->auth->getHeader();

        $this->response = $this->client->get($url, ['headers' => $headers]);
        $body = $this->response->getBody();

        return $this->stripNamespace($body);
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

    /**
     * As per https://github.com/schmittjoh/serializer/pull/301, JMS serializer doesn't support
     * namespace in XmlList and XmlMap, so we need to strip them out for now
     *
     * @param $str
     * @return string return
     */
    protected function stripNamespace($str)
    {
        return str_replace('atom:', '', $str);
    }
}