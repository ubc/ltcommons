<?php
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\LtCommons\Authentication\HttpBasic;
use UBC\LtCommons\HttpClient\GuzzleClient;
use UBC\LtCommons\Serializer\JMSSerializer;
use UBC\LtCommons\Service\Config;
use UBC\LtCommons\Service\DepartmentCodeService;

class DepartmentCodeServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;

    protected function setUp()
    {
        parent::setUp();
        $provider = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $provider->expects($this->any())
            ->method('getDepartmentCodes')
            ->willReturn(new \UBC\LtCommons\Entity\DepartmentCodes());

        $factory = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->any())
            ->method('getProvider')
            ->with('SIS_DEPARTMENT_CODE')
            ->willReturn($provider);

        $this->service = new DepartmentCodeService($factory);
    }

    public function testGetDepartmentCodes()
    {
        $codes = $this->service->getDepartmentCodes();
        $this->assertInstanceOf('\UBC\LtCommons\Entity\DepartmentCodes', $codes);
    }
}
 