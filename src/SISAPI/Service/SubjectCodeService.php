<?php
namespace UBC\SISAPI\Service;

class SubjectCodeService extends BaseService{
    const BASE_PATH = '/sisapi/v2';

    public function getSubjectCodes()
    {
        $response = $this->get('/subjectCode');
        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\SubjectCodes', 'xml');
    }
}
