<?php


namespace UBC\SISAPI\Entity;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlRoot;


/**
 * @XmlRoot("link")
 */
class Link {
    /**
     * @Type("string")
     * @XmlAttribute
     */
    private $href;
    /**
     * @Type("string")
     * @XmlAttribute
     */
    private $rel;

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param mixed $rel
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
    }
}