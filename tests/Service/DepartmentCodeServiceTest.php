<?php
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\SISAPI\Authentication\Basic;
use UBC\SISAPI\HttpClient\GuzzleClient;
use UBC\SISAPI\Serializer\JMSSerializer;
use UBC\SISAPI\Service\Config;
use UBC\SISAPI\Service\DepartmentCodeService;

class DepartmentCodeServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;
    private $client;
    private $mock;

    protected function setUp()
    {
        parent::setUp();

        $config = new Config(
            'http://sisapi.example.com',
            'service_username',
            'service_password'
        );

        $serializer = new JMSSerializer();
        $client = new GuzzleClient();
        $auth = new Basic();
        $auth->setUsername($config->getAuthUsername());
        $auth->setPassword($config->getAuthPassword());
        $this->service = new DepartmentCodeService($config, $client, $serializer, $auth);

        // Create a mock subscriber
        $this->mock = new Mock();
        $client->getEmitter()->attach($this->mock);
    }

    public function testGetDepartmentCodes()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/DepartmentCodes.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $codes = $this->service->getDepartmentCodes();

        $this->assertEquals(200, $this->service->getStatusCode());
        $this->assertEquals(3, count($codes->codes));
        $this->assertContainsOnlyInstancesOf('UBC\SISAPI\Entity\DepartmentCode', $codes->codes);
        $ids = array();
        foreach($codes->codes as $code) {
            $ids[] = $code->getId();
        }
        sort($ids);
        $this->assertEquals(
            array(
                'urn:ubc:departmentCode:AWFA~UBC',
                'urn:ubc:departmentCode:BKST~UBC',
                'urn:ubc:departmentCode:HSCI~UBC'
            ),
            $ids
        );
    }

    /**
     * @expectedException \GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessageRegExp /.*Internal Server Error/
     */
    public function testGetDepartmentCodes500()
    {
        $response = new Response(500);
        $this->mock->addResponse($response);

        $codes = $this->service->getDepartmentCodes();
    }

}
 