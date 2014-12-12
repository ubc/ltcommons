<?php
namespace UBC\LtCommons\Service;


class DepartmentCodeService extends BaseService
{
    public function getDepartmentCodes()
    {
        return $this->provider->getDepartmentCodes();
    }
}