<?php
namespace J\IV;
class Duty {
    private $name;
        public function setName($name) {
            $this->name = $name;
        }
        public function getName() {
            return $this->name;
        }
    private $information;
        public function setInformation($info) {
            $this->information = $info;
        }    
        public function getInformation() {
            return $this->information;
        }
}