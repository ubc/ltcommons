<?php
namespace UBC\LtCommons\Service;

class SubjectCodeService extends BaseService{

    public function getSubjectCodes()
    {
        return $this->providerFactory
            ->getProvider('SIS_SUBJECT_CODE')
            ->getSubjectCodes();
    }
}
