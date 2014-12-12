<?php


namespace UBC\LtCommons\Entity;


use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class Section {
    /**
     * @Type("string")
     */
    private $id;
    /**
     * @Type("string")
     */
    private $campus;
    /**
     * @Type("UBC\LtCommons\Entity\Course")
     */
    private $course;
    /**
     * @Type("array<UBC\LtCommons\Entity\Link>")
     * @XmlList(entry = "link", inline = true)
     */
    private $links;
    /**
     * @Type("array<string>")
     * @XmlList(entry = "term", inline = false)
     */
    private $terms;
    /**
     * @SerializedName("sectionNumber")
     * @Type("string")
     */
    private $sectionNumber;
    /**
     * @Type("string")
     */
    private $start;
    /**
     * @Type("string")
     */
    private $end;
    /**
     * @SerializedName("catalogNumber")
     * @Type("string")
     */
    private $catalogNumber;
    /**
     * @SerializedName("sessionRef")
     * @Type("UBC\LtCommons\Entity\SessionRef")
     */
    private $sessionRef;

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;
    }

    /**
     * @return mixed
     */
    public function getCatalogNumber()
    {
        return $this->catalogNumber;
    }

    /**
     * @param mixed $catalogNumber
     */
    public function setCatalogNumber($catalogNumber)
    {
        $this->catalogNumber = $catalogNumber;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
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
    public function getSectionNumber()
    {
        return $this->sectionNumber;
    }

    /**
     * @param mixed $sectionNumber
     */
    public function setSectionNumber($sectionNumber)
    {
        $this->sectionNumber = $sectionNumber;
    }

    /**
     * @return mixed
     */
    public function getSessionRef()
    {
        return $this->sessionRef;
    }

    /**
     * @param mixed $sessionRef
     */
    public function setSessionRef($sessionRef)
    {
        $this->sessionRef = $sessionRef;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->getSessionRef()->getCode();
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param mixed $terms
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->getSessionRef()->getYear();
    }
}