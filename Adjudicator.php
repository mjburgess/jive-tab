<?php
namespace J\IV;
class Adjudicator extends Person {
    private $rank;
        public function setRank($rank) {
            $this->rank = $rank;
        }    
        public function getRank() {
            return $this->rank;
        }    
        
    public function __construct($firstName, $secondName, $uni, $rank) {
        parent::__construct($firstName, $secondName, $uni);
        $this->rank = $rank;
    }    
    
    public function __toString() {
        return $this->getName();
    }
}