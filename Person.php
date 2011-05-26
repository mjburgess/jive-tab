<?php
namespace J\IV;
abstract class Person  {
    private $firstName, $lastName;
        public function setName($firstName, $lastName) {
            $this->firstName = $firstName; 
            $this->lastName  = $lastName;
        }    
        public function getName($asArray = false) {
            if($asArray) {
                return array($this->firstName, $this->lastName);
            } else {
                return $this->firstName . ' ' . $this->lastName;
            }
        }
    private $university;
        public function setUniversity($uni) {
            $this->university = $uni;
        }    
        public function getUniversity() {
            return $this->university;
        }
        
    public function __construct($firstName, $lastName, $uni) {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->university = $uni;
    }
}