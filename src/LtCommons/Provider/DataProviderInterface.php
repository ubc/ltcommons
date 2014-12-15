<?php


namespace UBC\LtCommons\Provider;


interface DataProviderInterface {
    static public function doesProvide($dataType);
    public function getStudentById($id);
    public function getStudentEligibilities($id);
    public function getStudentCurrentEligibility($id);
    public function getStudentCurrentSections($id);
    public function getDepartmentCodes();
    public function getSubjectCodes();
}