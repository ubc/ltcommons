<?php
/**
 * Created by PhpStorm.
 * User: compass
 * Date: 2014-11-27
 * Time: 5:07 PM
 */

namespace UBC\SISAPI\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class DepartmentCodes {
    /**
     * @XmlList(inline = true, entry = "departmentCode")
     * @Type("array<UBC\SISAPI\Entity\DepartmentCode>")
     */
    public $codes;
} 