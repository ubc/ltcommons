<?php


namespace UBC\LtCommons\Entity;


use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class Eligibility {
    /**
     * @Type("integer")
     */
    private $year;
    /**
     * @Type("string")
     */
    private $session;
    /**
     * @Type("array<UBC\LtCommons\Entity\Link>")
     * @XmlList(entry = "link", inline = true)
     */
    private $links;
    /**
     * @Type("string")
     */
    private $programCategory;
    /**
     * @Type("string")
     */
    private $program;
    /**
     * @Type("string")
     */
    private $programVersion;
    /**
     * @Type("string")
     */
    private $yearLevel;
    /**
     * @Type("string")
     */
    private $dualDegreeCode;
    /**
     * @Type("string")
     */
    private $campus;

    /**
     * @SerializedName("sections")
     * @Type("array<UBC\LtCommons\Entity\SectionRef>")
     * @XmlList(entry = "sectionRef", inline = false)
     */
    private $sectionRefs;

    /**
     * @return string|null
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
    public function getDualDegreeCode()
    {
        return $this->dualDegreeCode;
    }

    /**
     * @param mixed $dualDegreeCode
     */
    public function setDualDegreeCode($dualDegreeCode)
    {
        $this->dualDegreeCode = $dualDegreeCode;
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
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param mixed $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }

    /**
     * @return mixed
     */
    public function getProgramCategory()
    {
        return $this->programCategory;
    }

    /**
     * @param mixed $programCategory
     */
    public function setProgramCategory($programCategory)
    {
        $this->programCategory = $programCategory;
    }

    /**
     * @return mixed
     */
    public function getProgramVersion()
    {
        return $this->programVersion;
    }

    /**
     * @param mixed $programVersion
     */
    public function setProgramVersion($programVersion)
    {
        $this->programVersion = $programVersion;
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

    /**
     * @return mixed
     */
    public function getYearLevel()
    {
        return $this->yearLevel;
    }

    /**
     * @param mixed $yearLevel
     */
    public function setYearLevel($yearLevel)
    {
        $this->yearLevel = $yearLevel;
    }

    public function getEligibilityLink()
    {
        // if this object is populated by /student/{id}/eligibilities,
        // then this is an Ref object
        $search = 'http://sis.ubc.ca/rels/eligibility';
        if (null != $this->campus) {
            // we already populated this object
            $search = 'self';
        }
        foreach ($this->links as $link) {
            if ($link->getRel() == $search) {
                return $link->getHref();
            }
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getSectionRefs()
    {
        return $this->sectionRefs;
    }

    /**
     * @param mixed $sections
     */
    public function setSectionRefs($sections)
    {
        $this->sectionRefs = $sections;
    }
}