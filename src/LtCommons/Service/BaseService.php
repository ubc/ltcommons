<?php
namespace UBC\LtCommons\Service;

use UBC\LtCommons\Provider\DataProviderFactoryInterface;

abstract class BaseService
{
    protected $providerFactory;

    public function __construct(DataProviderFactoryInterface $providerFactory)
    {
        $this->providerFactory = $providerFactory;
    }
}