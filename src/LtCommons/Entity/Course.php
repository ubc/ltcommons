<?php


namespace UBC\LtCommons\Entity;


use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Course {
    /**
     * @Type("string")
     */
    private $id;
    /**
     * @Type("string")
     */
    private $name;
    /**
     * @SerializedName("shortName")
     * @Type("string")
     */
    private $shortName;
    /**
     * @Type("string")
     */
    private $code;
    /**
     * @SerializedName("detailCode")
     * @Type("string")
     */
    private $detailCode;
    /**
     * @Type("string")
     */
    private $number;

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
    public function getDetailCode()
    {
        return $this->detailCode;
    }

    /**
     * @param mixed $detailCode
     */
    public function setDetailCode($detailCode)
    {
        $this->detailCode = $detailCode;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param mixed $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }


} 