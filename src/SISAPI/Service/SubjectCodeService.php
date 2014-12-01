<?php
namespace UBC\SISAPI\Service;

class SubjectCodeService extends BaseService{
    const BASE_PATH = '/sisapi/v2';

    public function getSubjectCodes()
    {
        $response = $this->client->get(self::BASE_PATH.'/subjectCode');
        return $this->serializer->deserialize($response->getBody(), 'UBC\SISAPI\Entity\SubjectCodes', 'xml');
    }
}