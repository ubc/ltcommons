<?php
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\SISAPI\Authentication\Basic;
use UBC\SISAPI\HttpClient\GuzzleClient;
use UBC\SISAPI\Serializer\JMSSerializer;
use UBC\SISAPI\Service\Config;
use UBC\SISAPI\Service\SubjectCodeService;


class SubjectCodeServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;
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
        $this->service = new SubjectCodeService($config, $client, $serializer, $auth);

        // Create a mock subscriber
        $this->mock = new Mock();
        $client->getEmitter()->attach($this->mock);
    }

    public function testGetSubjectCodes()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/SubjectCodes.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $codes = $this->service->getSubjectCodes();

        $this->assertEquals(200, $this->service->getStatusCode());
        $this->assertEquals(3, count($codes->codes));
        $this->assertContainsOnlyInstancesOf('UBC\SISAPI\Entity\SubjectCode', $codes->codes);
        $ids = array();
        foreach($codes->codes as $code) {
            $ids[] = $code->getId();
        }
        sort($ids);
        $this->assertEquals(
            array(
                'urn:ubc:subjectCode:AMS~UBC',
                'urn:ubc:subjectCode:AWFA~UBC',
                'urn:ubc:subjectCode:BKST~UBC'
            ),
            $ids
        );
    }

    /**
     * @expectedException \GuzzleHttp\Exception\RequestException
     * @expectedExceptionMessageRegExp /.*Internal Server Error/
     */
    public function testGetSubjectCodes500()
    {
        $response = new Response(500);
        $this->mock->addResponse($response);

        $codes = $this->service->getSubjectCodes();
    }

}
 