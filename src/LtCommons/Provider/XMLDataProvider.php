<?php


namespace UBC\LtCommons\Provider;


use UBC\LtCommons\Serializer\Serializer;

class XMLDataProvider implements DataProviderInterface
{
    protected $path;
    protected $serializer;

    public function __construct($path = 'Fixtures/', Serializer $serializer)
    {
        $this->path = $path;
        $this->serializer = $serializer;
    }

    static public function doesProvide($dataType)
    {
        return in_array($dataType, array(
            'SIS_STUDENT',
            'SIS_DEPARTMENT_CODE',
            'SIS_SUBJECT_CODE'
        ));
    }

    public function getStudentById($id)
    {
        $response = $this->get('Student_'.$id.'.xml');

        return $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\Student', 'xml');
    }

    public function getStudentEligibilities($id)
    {
        $response = $this->get('Eligibilities_'.$id.'.xml');

        return $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\Eligibilities', 'xml');
    }

    public function getStudentCurrentEligibility($id)
    {
        $response = $this->get('Eligibility_'.$id.'.xml');

        return $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\Eligibility', 'xml');
    }

    public function getStudentCurrentSections($id)
    {
        $currentEligibility = $this->getStudentCurrentEligibility($id);
        if ($currentEligibility == null) {
            return array();
        }

        $sections = array();
        foreach ($currentEligibility->getSectionRefs() as $sectionRef) {
            $links = $sectionRef->getLinks();
            $url = $links[0]->getHref();
            $path = explode('/', $url);
            $id = end($path);
            $response = $this->get('Section_'.$id.'.xml');
            $sections[] = $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\Section', 'xml');
        }

        return $sections;
    }

    public function getDepartmentCodes()
    {
        $response = $this->get('DepartmentCodes.xml');

        return $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\DepartmentCodes', 'xml');
    }

    public function getSubjectCodes()
    {
        $response = $this->get('SubjectCodes.xml');

        return $this->serializer->deserialize($response, 'UBC\LtCommons\Entity\SubjectCodes', 'xml');
    }

    protected function get($file)
    {
        $content = @file_get_contents($this->path . $file);

        if (false === $content) {
           throw new \RuntimeException('Failed to load file '. $this->path . $file);
        }

        return $this->stripNamespace($content);
    }

    /**
     * As per https://github.com/schmittjoh/serializer/pull/301, JMS serializer doesn't support
     * namespace in XmlList and XmlMap, so we need to strip them out for now
     *
     * @param $str
     * @return string return
     */
    protected function stripNamespace($str)
    {
        return str_replace('atom:', '', $str);
    }
}
