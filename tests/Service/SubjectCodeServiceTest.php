<?php
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\LtCommons\Authentication\BasicHttp;
use UBC\LtCommons\HttpClient\GuzzleClient;
use UBC\LtCommons\Serializer\JMSSerializer;
use UBC\LtCommons\Service\Config;
use UBC\LtCommons\Service\SubjectCodeService;


class SubjectCodeServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;

    protected function setUp()
    {
        parent::setUp();
        $provider = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $provider->expects($this->any())
            ->method('getSubjectCodes')
            ->willReturn(new \UBC\LtCommons\Entity\SubjectCodes());

        $factory = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->any())
            ->method('getProvider')
            ->with('SIS_SUBJECT_CODE')
            ->willReturn($provider);

        $this->service = new SubjectCodeService($factory);
    }

    public function testGetSubjectCodes()
    {
        $codes = $this->service->getSubjectCodes();
        $this->assertInstanceOf('\UBC\LtCommons\Entity\SubjectCodes', $codes);
    }
}
 