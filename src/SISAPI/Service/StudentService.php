<?php


namespace UBC\SISAPI\Service;


class StudentService extends BaseService
{
    public function getStudentById($id)
    {
        return $this->provider->getStudentById($id);
    }

    public function getStudentEligibilities($id)
    {
        return $this->provider->getStudentEligibilities($id);
    }

    public function getStudentCurrentEligibility($id)
    {
        return $this->provider->getStudentCurrentEligibility($id);
    }

    public function getStudentCurrentSections($id)
    {
        return $this->provider->getStudentCurrentSections($id);
    }
}