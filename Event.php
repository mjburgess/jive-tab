<?php
namespace J\IV;
class Event  {
    private $name;
        public function setName($n) {
            $this->name = $n;
        }
        public function getName() {
            return $this->name;
        }
    private $time;
        public function setTime($t) {
            $this->time = $t;
        }
        public function getTime() {
            return $this->time;
        }
    private $location;
        public function setLocation($l) {
            $this->location = $l;
        }
        public function getLocation() {
            return $this->location;
        }
    private $type;
        public function setType($t) {
            $this->type = $t;
        }
        public function getType() {
            return $this->type;
        }
    private $postition;
        public function getPosition() {
            return $this->postition;
        }
        public function setPosition($p) {
            $this->postition = $p;
        }
    public function __construct($name, $time, $location, $type) {
        $this->name = $name;
        $this->time = $time;
        $this->location = $location;
        $this->type = $type;
        $this->postition = strtotime($time);
    }
}