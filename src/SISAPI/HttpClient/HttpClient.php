<?php
namespace UBC\SISAPI\HttpClient;


interface HttpClient {
    public function get($uri, array $options = array());
    public function getResponse();
}