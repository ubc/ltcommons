<?php
namespace UBC\SISAPI\Service;

class SubjectCodeService extends BaseService{

    public function getSubjectCodes()
    {
        return $this->provider->getSubjectCodes();
    }
}
