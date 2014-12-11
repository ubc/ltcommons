<?php


namespace UBC\SISAPI\Entity;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class SessionRef {
    /**
     * @Type("integer")
     */
    private $year;
    /**
     * @Type("string")
     */
    private $code;
    /**
     * @Type("array<UBC\SISAPI\Entity\Link>")
     * @XmlList(entry = "link", inline = true)
     */
    private $links;

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param mixed $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
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

    public function getSessionLink() {
        foreach ($this->links as $link) {
            if ('http://sis.ubc.ca/rels/session' == $link->getRel()) {
                return $link->getHref();
            }
        }

        return null;
    }
}