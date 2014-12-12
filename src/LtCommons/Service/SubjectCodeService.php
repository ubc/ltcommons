<?php
namespace UBC\LtCommons\Service;

class SubjectCodeService extends BaseService{

    public function getSubjectCodes()
    {
        return $this->provider->getSubjectCodes();
    }
}
