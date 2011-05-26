<?php
namespace J\IV;
class Staff extends Person {
    private $postion;
        public function setPosition($pos) {
            $this->postion = $pos;
        }
        public function getPostition() {
            return $this->postion;
        }
    private $duties;
        public function setDuties(array $duties) {
            $this->duties = $duties;
        }
        public function getDuties() {
            return $this->duties;
        }
        public function addDuty(\J\IV\Duty $duty) {
            $this->duties[$duty->getName()] = $duty;
        }
        public function removeDuty($name) {
            unset($this->duties[$name]);
        }
}