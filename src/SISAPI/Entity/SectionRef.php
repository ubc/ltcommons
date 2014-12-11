<?php


namespace UBC\SISAPI\Entity;


use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class SectionRef {
    /**
     * @Type("integer")
     */
    private $year;
    /**
     * @Type("string")
     */
    private $session;
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
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
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

    public function getSectionLink() {
        foreach ($this->links as $link) {
            if ('http://sis.ubc.ca/rels/section' == $link->getRel()) {
                return $link->getHref();
            }
        }

        return null;
    }
}