<?php


namespace UBC\LtCommons\Entity;


use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlList;

class Eligibilities {
    /**
     * @Type("array<UBC\LtCommons\Entity\Eligibility>");
     * @XmlList(entry = "eligibilityRef", inline = true)
     * @var array
     */
    private $eligibilites = array();

    /**
     * @return array
     */
    public function getEligibilites()
    {
        return $this->eligibilites;
    }

    /**
     * @param array $eligibilites
     */
    public function setEligibilites($eligibilites)
    {
        $this->eligibilites = $eligibilites;
    }

    public function getCurrentEligibility()
    {
        $month = date('n');
        $year = date('Y');
        if ($month > 4 && $month < 9) {
            $session = 'S';
        } else {
            $session = 'W';

            // if we are in Feb, 2015, it is still 2014 winter term
            if ($month <= 4) {
                $year--;
            }
        }

        foreach ($this->eligibilites as $e) {
            if ($e->getYear() == $year && $e->getSession() == $session) {
                return $e;
            }
        }

        return null;
    }
}