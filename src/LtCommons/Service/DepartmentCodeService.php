<?php
namespace UBC\LtCommons\Service;


class DepartmentCodeService extends BaseService
{
    public function getDepartmentCodes()
    {
        return $this->providerFactory
            ->getProvider('SIS_DEPARTMENT_CODE')
            ->getDepartmentCodes();
    }
}