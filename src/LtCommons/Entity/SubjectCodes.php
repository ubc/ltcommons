<?php
namespace UBC\LtCommons\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class SubjectCodes
{
    /**
     * @XmlList(inline = true, entry = "subjectCode")
     * @Type("array<UBC\LtCommons\Entity\SubjectCode>")
     */
    public $codes;
}
