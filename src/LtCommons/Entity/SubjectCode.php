<?php
namespace UBC\LtCommons\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

class SubjectCode
{
    /**
     * @Type("string")
     */
    private $id;

    /**
     * @SerializedName("adminCampusCode")
     * @Type("string")
     */
    private $adminCampusCode;

    /**
     * @SerializedName("fullDescription")
     * @Type("string")
     */
    private $fullDescription;

    /**
     * @SerializedName("departmentCode")
     * @Type("string")
     */
    private $departmentCode;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAdminCampusCode()
    {
        return $this->adminCampusCode;
    }

    /**
     * @param mixed $adminCampusCode
     */
    public function setAdminCampusCode($adminCampusCode)
    {
        $this->adminCampusCode = $adminCampusCode;
    }

    /**
     * @return mixed
     */
    public function getFullDescription()
    {
        return $this->fullDescription;
    }

    /**
     * @param mixed $fullDescription
     */
    public function setFullDescription($fullDescription)
    {
        $this->fullDescription = $fullDescription;
    }

    /**
     * @return mixed
     */
    public function getDepartmentCode()
    {
        return $this->departmentCode;
    }

    /**
     * @param mixed $departmentCode
     */
    public function setDepartmentCode($departmentCode)
    {
        $this->departmentCode = $departmentCode;
    }
}
