<?php

namespace UBC\LtCommons\Tests\Provider;

use UBC\LtCommons\Provider\DataProviderFactory;
use UBC\LtCommons\Provider\SISDataProvider;

class DataProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetProviderSISDataProvider()
    {
        $factory = new DataProviderFactory(array(array(
            'class' => 'UBC\LtCommons\Provider\SISDataProvider',
            'arguments' => array(
                'http://sisapi.example.com',
                $this->getMock('UBC\LtCommons\HttpClient\GuzzleClient'),
                $this->getMock('UBC\LtCommons\Authentication\HttpBasic'),
                $this->getMock('UBC\LtCommons\Serializer\JMSSerializer')
            )
        )));

        $provider = $factory->getProvider('SIS_STUDENT');

        $this->assertTrue($provider instanceof \UBC\LtCommons\Provider\SISDataProvider);
    }

    public function testGetProviderWithService()
    {
        $factory = new DataProviderFactory(array(
            new SISDataProvider(
                'http://sisapi.example.com',
                $this->getMock('UBC\LtCommons\HttpClient\GuzzleClient'),
                $this->getMock('UBC\LtCommons\Authentication\HttpBasic'),
                $this->getMock('UBC\LtCommons\Serializer\JMSSerializer')
            )
        ));

        $provider = $factory->getProvider('SIS_STUDENT');

        $this->assertTrue($provider instanceof \UBC\LtCommons\Provider\SISDataProvider);
    }
} 