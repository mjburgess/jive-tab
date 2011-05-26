<?php
namespace J\IV;
class Speaker extends Person {
    private $eduStatus;
        const Novice    = 0;
        const UnderGrad = 1;
        const Graduate  = 2;
        const PostGrad  = 3;
        const Open      = 4;
        
        public function setEduStatus($status) {
            $this->eduStatus = $status;
        }    
        public function getEduStatus($asText = true) {
            $text = array('Novice', 'Under-Graduate', 'Graduate', 'Post-Graduate', 'Open');
            return $asText ? $text[$this->eduStatus] : $this->eduStatus;
        }
    
    private $speaks;
        public function setSpeaks($spks, $round = '++') {
            if(is_int($round)) {
                $this->speaks[$round] = $spks;
            } else {
                $this->speaks[] = $spks;
            }
        }    
        public function getSpeaks($asArray = false) {
            return $asArray ? $this->speaks : array_sum($this->speaks);
        }
        public function getAverageSpeaks() {
            $num = count($this->speaks) - 1;
            return array_sum($this->speaks) / ($num ? $num : 1);
        }
        
    public function __construct($firstName, $lastName, $uni, $eduStatus) {
        parent::__construct($firstName, $lastName, $uni);
        $this->eduStatus = $eduStatus;
        $this->speaks = array();
        $this->rounds = 0;
    }    
}