<?php
namespace J\IV;
class Team  {
    private $name;
        public function setTeamName($name) {
            $this->name = $name;
        }
        public function getTeamName() {
            return $this->name;
        }
        
    private $representing;
        public function setRepresenting($rep) {
            $this->representing = $rep;
        }
        public function getRepresenting() {
            return $this->representing;
        }    
        
    private $firstSpeaker, $secondSpeaker;
        public function setSpeakers(\J\IV\Speaker $one, \J\IV\Speaker $two) {
            $this->firstSpeaker = $one;
            $this->secondSpeaker = $two;
        }
        public function getSpeakers() {
            return array($this->firstSpeaker, $this->secondSpeaker);
        }
        
    public function getSpeaks($sum = true) {
        if($sum) { 
            return $this->firstSpeaker->getSpeaks() + $this->secondSpeaker->getSpeaks();
        } else {
            return array($this->firstSpeaker->getSpeaks(true), $this->secondSpeaker->getSpeaks(true));
        }
    }
    
    public function getAverageSpeaks() {
        return 0.5 * ($this->firstSpeaker->getAverageSpeaks() + 
                        $this->secondSpeaker->getAverageSpeaks());
    }
    
    public function setSpeaks($first, $second) {
        $this->firstSpeaker->setSpeaks($first);
        $this->secondSpeaker->setSpeaks($second);
    }
    
    public function __construct($name, $representing, $firstCompt, $secondCompt) {
        $this->name = $name;
        $this->representing = $representing;
        $this->firstSpeaker = $firstCompt;
        $this->secondSpeaker = $secondCompt;
    }
    
    public function __toString() {
        return sprintf("%s @ %.1f from %s\n\t> %s @ %d\n\t> %s @ %d\n\n",
                       $this->name, $this->getAverageSpeaks(), $this->representing,
                       $this->firstSpeaker->getName(), $this->firstSpeaker->getSpeaks(),
                       $this->secondSpeaker->getName(), $this->secondSpeaker->getSpeaks(),
                       $this->name);
    }
}