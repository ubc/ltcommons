<?php
namespace UBC\SISAPI\Service;

use UBC\SISAPI\Provider\DataProvider;

abstract class BaseService
{
    protected $config;
    protected $provider;
    protected $baseUrl;
    protected $auth_username;
    protected $auth_password;
    protected $auth_token;

    protected $response;
    protected $request;

    public function __construct(Config $config, DataProvider $provider)
    {
        $this->config = $config;
        $this->provider = $provider;
    }
}