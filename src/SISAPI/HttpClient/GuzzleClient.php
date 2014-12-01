<?php
namespace UBC\SISAPI\HttpClient;


use GuzzleHttp\Client;

class GuzzleClient implements HttpClient
{
    protected $client;
    protected $response;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get($uri, array $options = array())
    {
        $this->response = $this->client->get($uri, $options);

        return $this->response;
    }

    public function getEmitter()
    {
        return $this->client->getEmitter();
    }

    public function getResponse()
    {
        return $this->response;
    }
}