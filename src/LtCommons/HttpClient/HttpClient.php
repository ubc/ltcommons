<?php
namespace UBC\LtCommons\HttpClient;


interface HttpClient {
    public function get($uri, array $options = array());
    public function getResponse();
}