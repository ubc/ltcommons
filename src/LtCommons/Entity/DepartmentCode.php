<?php
/**
 * Created by PhpStorm.
 * User: compass
 * Date: 2014-11-27
 * Time: 5:02 PM
 */

namespace UBC\LtCommons\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

class DepartmentCode
{
    /**
     * @Type("string")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $code;

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
     * @SerializedName("adminFacultyCode")
     * @Type("string")
     */
    private $adminFacultyCode;

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
    public function getAdminFacultyCode()
    {
        return $this->adminFacultyCode;
    }

    /**
     * @param mixed $adminFacultyCode
     */
    public function setAdminFacultyCode($adminFacultyCode)
    {
        $this->adminFacultyCode = $adminFacultyCode;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}