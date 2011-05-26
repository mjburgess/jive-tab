<?php
namespace J\IV;
class Room  {
    private $id;
        public function setID($id) {
            $this->id = $id;
        }
        public function getID() {
            return $this->id;
        }
    private $location;
        public function setLocation($loc) {
            $this->location = $loc;
        }
        public function getLocation() {
            return $this->location;
        }
    private $teams;
        public function setTeams(array $teams) {
            $this->teams = $teams;
        }    
        public function getTeams() {
            return $this->teams;
        }
    private $chair;
        public function setChair(\J\IV\Adjudicator $ad) {
            $this->chair = $ad;
        }
        public function getChair() {
            return $this->chair;
        }
    private $wings;
        public function setWings(array $wings) {
            $this->wings = $wings;
        }    
        public function getWings() {
            return $this->wings;
        }
        public function addWing(\J\IV\Adjudicator $w) {
            $this->wings[$w->getName()] = $w;
        }
        public function getWing($name) {
            return $this->wings[$name];
        }
        public function removeWing($name) {
            unset($this->wings[$name]);
        }
        
    public function __construct($id, $location) {
        $this->id = $id;
        $this->location = $location;
    }    
    
    public function __toString() {
        $out = "$this->id @ $this->location\n
                Judging: $this->chair &\n" . '(' . implode(', ', $this->wings) . ")\n\n";
        foreach($this->teams as $team) {
            $out .= "\t$team";
        }
        $out .= "\nEnd $this->id \n\n";
        return $out;
    } 
}