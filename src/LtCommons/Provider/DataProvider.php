<?php


namespace UBC\LtCommons\Provider;


interface DataProvider {
    public function getStudentById($id);
    public function getStudentEligibilities($id);
    public function getStudentCurrentEligibility($id);
    public function getStudentCurrentSections($id);
    public function getDepartmentCodes();
    public function getSubjectCodes();
}