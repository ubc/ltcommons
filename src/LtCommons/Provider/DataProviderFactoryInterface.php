<?php


namespace UBC\LtCommons\Provider;


interface DataProviderFactoryInterface {
    public function getProvider($dataType);
} 