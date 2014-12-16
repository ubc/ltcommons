<?php


namespace UBC\LtCommons\Tests\Service;


use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use UBC\LtCommons\Authentication\HttpBasic;
use UBC\LtCommons\Entity\Eligibilities;
use UBC\LtCommons\Entity\Eligibility;
use UBC\LtCommons\Entity\Section;
use UBC\LtCommons\Entity\Student;
use UBC\LtCommons\HttpClient\GuzzleClient;
use UBC\LtCommons\Provider\SISDataProvider;
use UBC\LtCommons\Provider\SISDataProviderInterface;
use UBC\LtCommons\Serializer\JMSSerializer;
use UBC\LtCommons\Service\Config;
use UBC\LtCommons\Service\StudentService;


class StudentServiceTest extends \PHPUnit_Framework_TestCase {
    private $service;
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
        $provider = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $provider->expects($this->any())
            ->method('getStudentById')
            ->with('12345678')
            ->willReturn(new Student());

        $provider->expects($this->any())
            ->method('getStudentEligibilities')
            ->with('12345678')
            ->willReturn(new Eligibilities());

        $provider->expects($this->any())
        ->method('getStudentCurrentEligibility')
        ->with('12345678')
        ->willReturn(new Eligibility());

        $provider->expects($this->any())
            ->method('getStudentCurrentSections')
            ->with('12345678')
            ->willReturn(array(new Section()));

        $factory = $this->getMockBuilder('\UBC\LtCommons\Provider\DataProviderFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $factory->expects($this->any())
            ->method('getProvider')
            ->with('SIS_STUDENT')
            ->willReturn($provider);

        $this->service = new StudentService($factory);
    }

    public function testGetStudent()
    {
        $student = $this->service->getStudentById('12345678');
        $this->assertInstanceOf('UBC\LtCommons\Entity\Student', $student);
    }

    public function testGetStudentEligibilities()
    {
        $eligibilites = $this->service->getStudentEligibilities('12345678');
        $this->assertInstanceOf('UBC\LtCommons\Entity\Eligibilities', $eligibilites);
    }

    public function testGetStudentCurrentEligibility()
    {
        $eligibility = $this->service->getStudentCurrentEligibility('12345678');
        $this->assertInstanceOf('UBC\LtCommons\Entity\Eligibility', $eligibility);
    }


    public function testGetStudentCurrentSections()
    {
        $sections = $this->service->getStudentCurrentSections('12345678');
        $this->assertEquals(1, count($sections));
        $this->assertContainsOnlyInstancesOf('UBC\LtCommons\Entity\Section', $sections);
    }
}
 