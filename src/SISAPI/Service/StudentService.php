<?php


namespace UBC\SISAPI\Service;


class StudentService extends BaseService {
    public function getStudentById($id)
    {
        $response = $this->get('/student/'.$id);

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Student', 'xml');
    }

    public function getStudentEligibilities($id)
    {
        $student = $this->getStudentById($id);
        $response = $this->get($student->getEligibilityLink());

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Eligibilities', 'xml');
    }

    public function getStudentCurrentEligibility($id)
    {
        $eligibilities = $this->getStudentEligibilities($id);
        $current = $eligibilities->getCurrentEligibility();
        if ($current == null) {
            return null;
        }
        $response = $this->get($current->getEligibilityLink());

        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Eligibility', 'xml');
    }

    public function getStudentCurrentSections($id) {
        $currentEligibility = $this->getStudentCurrentEligibility($id);
        if ($currentEligibility == null) {
            return array();
        }

        $sections = array();
        foreach ($currentEligibility->getSectionRefs() as $sectionRef) {
            $response = $this->get($sectionRef->getSectionLink());
            $sections[] = $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\Section', 'xml');
        }

        return $sections;
    }
}