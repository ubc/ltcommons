<?php
namespace UBC\SISAPI\Service;


class DepartmentCodeService extends BaseService
{
    public function getDepartmentCodes()
    {
        $response = $this->get('/departmentCode');
        return $this->serializer->deserialize($response, 'UBC\SISAPI\Entity\DepartmentCodes', 'xml');
    }
}