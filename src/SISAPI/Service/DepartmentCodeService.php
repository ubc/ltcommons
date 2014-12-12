<?php
namespace UBC\SISAPI\Service;


class DepartmentCodeService extends BaseService
{
    public function getDepartmentCodes()
    {
        return $this->provider->getDepartmentCodes();
    }
}