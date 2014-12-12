<?php


namespace UBC\SISAPI\Tests\Service;


use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\SISAPI\Authentication\Basic;
use UBC\SISAPI\HttpClient\GuzzleClient;
use UBC\SISAPI\Provider\SISDataProvider;
use UBC\SISAPI\Serializer\JMSSerializer;
use UBC\SISAPI\Service\Config;
use UBC\SISAPI\Service\StudentService;


class StudentServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;
    private $client;
    private $mock;

    /**
     * @return string
     */
    protected static function getCurrentEligibilityData()
    {
        $year = date('n') < 5 ? date('Y') - 1 : date('Y');
        $data = <<<EOF
<eligibilities xmlns="http://ubc.ca/sis/services/sisapi" xmlns:atom="http://www.w3.org/2005/Atom">
    <atom:link href="http://sisapi.example.com/sisapi/v2/student/WYZ2B1O7QD55/eligibilities" rel="self"/>
    <atom:link href="http://sisapi.example.com/sisapi/v2/student/WYZ2B1O7QD55" rel="http://sis.ubc.ca/rels/student"/>
    <eligibilityRef>
        <atom:link href="http://sisapi.example.com/sisapi/v2/eligibility/202672233" rel="http://sis.ubc.ca/rels/eligibility"/>
        <year>$year</year>
        <session>W</session>
    </eligibilityRef>
    <eligibilityRef>
        <atom:link href="http://sisapi.example.com/sisapi/v2/eligibility/226444769" rel="http://sis.ubc.ca/rels/eligibility"/>
        <year>$year</year>
        <session>S</session>
    </eligibilityRef>
</eligibilities>
EOF;
        return $data;
    }

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
        $provider = new SISDataProvider($config, $client, $auth, $serializer);
        $this->service = new StudentService($config, $provider);

        // Create a mock subscriber
        $this->mock = new Mock();
        $client->getEmitter()->attach($this->mock);
    }

    public function testGetStudent()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $student = $this->service->getStudentById('12345678');

        $this->assertInstanceOf('UBC\SISAPI\Entity\Student', $student);
        $this->assertEquals('12345678', $student->getStudentNumber());
        $this->assertEquals(9, count($student->getLinks()));
    }

    public function testGetStudentEligibilities()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Eligibilities.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $eligibilites = $this->service->getStudentEligibilities('12345678');

        $this->assertInstanceOf('UBC\SISAPI\Entity\Eligibilities', $eligibilites);
        $this->assertEquals(12, count($eligibilites->getEligibilites()));
    }

    public function testGetStudentCurrentEligibility()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen('data://text/plain,' . self::getCurrentEligibilityData(), 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Eligibility.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $eligibility = $this->service->getStudentCurrentEligibility('12345678');
        $this->assertInstanceOf('UBC\SISAPI\Entity\Eligibility', $eligibility);
        $this->assertEquals(2005, $eligibility->getYear());
        $this->assertEquals(2, count($eligibility->getSectionRefs()));

        // test no current eligibility

        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Eligibilities.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $eligibility = $this->service->getStudentCurrentEligibility('12345678');

        $this->assertNull($eligibility, 'should return null when no current eligibility');
    }


    public function testGetStudentCurrentSections()
    {
        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen('data://text/plain,' . self::getCurrentEligibilityData(), 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Eligibility.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Section1.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Section2.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $sections = $this->service->getStudentCurrentSections('12345678');
        $this->assertContainsOnlyInstancesOf('UBC\SISAPI\Entity\Section', $sections);
        $this->assertEquals(2, count($sections));

        $this->assertEquals('urn:ubc:section:2005W_54', $sections[0]->getId());
        $this->assertEquals('UBC', $sections[0]->getCampus());
        $this->assertEquals('Adult Education and Community', $sections[0]->getCourse()->getName());
        $this->assertEquals('ADULT ED COMM', $sections[0]->getCourse()->getShortName());
        $this->assertEquals('ADHE', $sections[0]->getCourse()->getCode());
        $this->assertEquals('501', $sections[0]->getCourse()->getNumber());
        $this->assertEquals('2005', $sections[0]->getYear());
        $this->assertEquals('W', $sections[0]->getSession());
        $this->assertEquals(array(2), $sections[0]->getTerms());
        $this->assertEquals('022', $sections[0]->getSectionNumber());
        $this->assertEquals('2006-01-04', $sections[0]->getStart());
        $this->assertEquals('2006-04-07', $sections[0]->getEnd());
        $this->assertEquals('54', $sections[0]->getCatalogNumber());

        $this->assertEquals('urn:ubc:section:2005W_57357', $sections[1]->getId());
        $this->assertEquals('UBC', $sections[1]->getCampus());
        $this->assertEquals('Research Methodology in Education', $sections[1]->getCourse()->getName());
        $this->assertEquals('RES MTHD IN EDUC', $sections[1]->getCourse()->getShortName());
        $this->assertEquals('EDUC', $sections[1]->getCourse()->getCode());
        $this->assertEquals('500', $sections[1]->getCourse()->getNumber());
        $this->assertEquals('2005', $sections[1]->getYear());
        $this->assertEquals('W', $sections[1]->getSession());
        $this->assertEquals(array(2), $sections[1]->getTerms());
        $this->assertEquals('002', $sections[1]->getSectionNumber());
        $this->assertEquals('2006-01-04', $sections[1]->getStart());
        $this->assertEquals('2006-04-07', $sections[1]->getEnd());
        $this->assertEquals('57357', $sections[1]->getCatalogNumber());
    }

    public function testGetStudentCurrentSectionsWithNoCurrentEligibility()
    {
        // test no current eligibility

        // load the fixture xml and prepare the mock response
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Student.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);
        $body = fopen(dirname(__FILE__) . '/../Fixtures/Eligibilities.xml', 'r');
        $response = new Response(200, [], Stream::factory($body));
        $this->mock->addResponse($response);

        $sections = $this->service->getStudentCurrentSections('12345678');

        $this->assertEmpty($sections, 'should return empty when no current eligibility');
    }
}
 