<?php


namespace UBC\LtCommons\Tests\Provider;


use UBC\LtCommons\Provider\XMLDataProvider;
use UBC\LtCommons\Serializer\JMSSerializer;

class XMLDataProviderTest extends \PHPUnit_Framework_TestCase
{
    const STUDENT_ID = '12345678';
    private $provider;

    protected function setUp()
    {
        parent::setUp();

        $serializer = new JMSSerializer();
        $this->provider = new XMLDataProvider(__DIR__ . '/../Fixtures/', $serializer);
    }

    public function testGetStudentById()
    {
        $student = $this->provider->getStudentById(self::STUDENT_ID);

        $this->assertInstanceOf('UBC\LtCommons\Entity\Student', $student);
        $this->assertEquals(self::STUDENT_ID, $student->getStudentNumber());
        $this->assertEquals(9, count($student->getLinks()));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp /Failed to load file.*$/
     */
    public function testGetStudentByIdWithNonExistingId()
    {
        $this->provider->getStudentById('NONEXISTING');
    }

    public function testGetStudentEligibilities()
    {
        $eligibilites = $this->provider->getStudentEligibilities(self::STUDENT_ID);

        $this->assertInstanceOf('UBC\LtCommons\Entity\Eligibilities', $eligibilites);
        $this->assertEquals(12, count($eligibilites->getEligibilites()));
    }

    public function testGetStudentCurrentEligibility()
    {
        $eligibility = $this->provider->getStudentCurrentEligibility(self::STUDENT_ID);
        $this->assertInstanceOf('UBC\LtCommons\Entity\Eligibility', $eligibility);
        $this->assertEquals(2005, $eligibility->getYear());
        $this->assertEquals(2, count($eligibility->getSectionRefs()));
    }


    public function testGetStudentCurrentSections()
    {
        $sections = $this->provider->getStudentCurrentSections(self::STUDENT_ID);
        $this->assertContainsOnlyInstancesOf('UBC\LtCommons\Entity\Section', $sections);
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

    public function testGetDepartmentCodes()
    {
        $codes = $this->provider->getDepartmentCodes();

        $this->assertEquals(3, count($codes->codes));
        $this->assertContainsOnlyInstancesOf('UBC\LtCommons\Entity\DepartmentCode', $codes->codes);
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

    public function testGetSubjectCodes()
    {
        $codes = $this->provider->getSubjectCodes();

        $this->assertEquals(3, count($codes->codes));
        $this->assertContainsOnlyInstancesOf('UBC\LtCommons\Entity\SubjectCode', $codes->codes);
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

}
 