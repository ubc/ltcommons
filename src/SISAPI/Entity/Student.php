<?php


namespace UBC\SISAPI\Entity;


use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlNamespace;

/**
 * Class Student
 * @package UBC\SISAPI\Entity
 * @XmlNamespace(uri="http://www.w3.org/2005/Atom", prefix="atom")
 */
class Student
{
    /**
     * @Type("string")
     */
    private $id;

    /**
     * @Type("string")
     */
    private $puid;

    /**
     * @Type("string")
     */
    private $gender;

    /**
     * @SerializedName("studentNumber")
     * @Type("string")
     */
    private $studentNumber;
    /**
     * @SerializedName("firstname")
     * @Type("string")
     */
    private $firstName;
    /**
     * @SerializedName("lastname")
     * @Type("string")
     */
    private $lastName;
    /**
     * @Type("string")
     */
    private $middleName;
    /**
     * @Type("string")
     */
    private $preferredName;
    /**
     * @SerializedName("countryOfCitizenship")
     * @Type("string")
     */
    private $citizenship;
    /**
     * @Type("boolean")
     */
    private $studentVisa = false;
    /**
     * @Type("boolean")
     */
    private $aboriginal = false;
    /**
     * @Type("string")
     */
    private $email;
    /**
     * @SerializedName("primaryPhoneNo")
     * @Type("string")
     */
    private $phone;

    /**
     * @Type("array<UBC\SISAPI\Entity\Link>")
     * @XmlList(entry = "link", inline = true)
     */
    private $links = array();

    /**
     * @return boolean
     */
    public function isAboriginal()
    {
        return $this->aboriginal;
    }

    /**
     * @param boolean $aboriginal
     */
    public function setAboriginal($aboriginal)
    {
        $this->aboriginal = $aboriginal;
    }

    /**
     * @return mixed
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }

    /**
     * @param mixed $citizenship
     */
    public function setCitizenship($citizenship)
    {
        $this->citizenship = $citizenship;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
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
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPreferredName()
    {
        return $this->preferredName;
    }

    /**
     * @param mixed $preferredName
     */
    public function setPreferredName($preferredName)
    {
        $this->preferredName = $preferredName;
    }

    /**
     * @return mixed
     */
    public function getPuid()
    {
        return $this->puid;
    }

    /**
     * @param mixed $puid
     */
    public function setPuid($puid)
    {
        $this->puid = $puid;
    }

    /**
     * @return mixed
     */
    public function getStudentNumber()
    {
        return $this->studentNumber;
    }

    /**
     * @param mixed $studentNumber
     */
    public function setStudentNumber($studentNumber)
    {
        $this->studentNumber = $studentNumber;
    }

    /**
     * @return boolean
     */
    public function isStudentVisa()
    {
        return $this->studentVisa;
    }

    /**
     * @param boolean $studentVisa
     */
    public function setStudentVisa($studentVisa)
    {
        $this->studentVisa = $studentVisa;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->links[] = $link;
    }

    public function getEligibilityLink()
    {
        foreach ($this->links as $link) {
            if ('http://sis.ubc.ca/rels/eligibilities' == $link->getRel()) {
                return $link->getHref();
            }
        }

        return null;
    }
}