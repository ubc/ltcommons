<?php


namespace UBC\LtCommons\Service;


class StudentService extends BaseService
{
    public function getStudentById($id)
    {
        return $this->providerFactory
            ->getProvider('SIS_STUDENT')
            ->getStudentById($id);
    }

    public function getStudentEligibilities($id)
    {
        return $this->providerFactory
            ->getProvider('SIS_STUDENT')
            ->getStudentEligibilities($id);
    }

    public function getStudentCurrentEligibility($id)
    {
        return $this->providerFactory
            ->getProvider('SIS_STUDENT')
            ->getStudentCurrentEligibility($id);
    }

    public function getStudentCurrentSections($id)
    {
        return $this->providerFactory
            ->getProvider('SIS_STUDENT')
            ->getStudentCurrentSections($id);
    }
}