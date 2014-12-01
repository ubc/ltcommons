<?php
namespace UBC\SISAPI\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class SubjectCodes
{
    /**
     * @XmlList(inline = true, entry = "subjectCode")
     * @Type("array<UBC\SISAPI\Entity\SubjectCode>")
     */
    public $codes;
}
