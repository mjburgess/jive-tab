<?php
namespace J\IV;
class Tab {
    private $rooms;
        public function setRooms(array $rooms) {
            $this->rooms = $rooms;
        }
        public function getRooms() {
            return $this->rooms;
        }
        public function addRoom(\J\IV\Room $r) {
            $this->rooms[$r->getID()] = $r;
        }
        public function getRoom($id) {
            return $this->rooms[$id];
        }
        public function removeRoom($id) {
            unset($this->rooms[$id]);
        }
    private $teams;
        public function setTeams(array $teams) {
            $this->teams = $teams;
        }
        public function getTeams() {
            return $this->teams;
        }
        public function addTeam(\J\IV\Team $team) {
            $this->teams[$team->getTeamName()] = $team;
        }
        public function getTeam($name) {
            return $this->teams[$name];
        }       
    private $adjudicators;
        public function setAdjudicators(array $adjs) {
            $this->adjudicators = $adjs;
        }
        public function getAdjudicators() {
            return $this->adjudicators;
        }
        public function addAdjudicator(\J\IV\Adjudicator $adj) {
            $this->adjudicators[$adj->getName()] = $adj;
        }
        public function getAdjudicator($name) {
            return $this->adjudicators[$name];
        }      
    private $adjudicatorDistribution;
        const Random = 1;      
        public function setAdjudicatorDistribution($ad) {
            $this->adjudicatorDistribution = $ad;
        }            
        public function getAdjudicatorDistribution() {
            return $this->adjudicatorDistribution;
        }
        
    public function __construct(array $rooms = array(), array $teams = array(), 
                                array $adjudicators = array(), $adjuDist = 0) {
        $this->setRooms($rooms);
        $this->setAdjudicators($adjudicators);
        $this->setTeams($teams);
        $this->setAdjudicatorDistribution($adjuDist);
    }
    
    public function averageSpeaks() {
        $avg = 0;
        foreach($this->teams as $team) {
            $avg += $team->getAverageSpeaks();
        }
        
        return round($avg/count($this->teams));
    }  
    private function rankTeams(\J\IV\Team $a, \J\IV\Team $b) {
        if ($a->getSpeaks() == $b->getSpeaks()) {
            return 0;
        }
        
        return $a->getSpeaks() > $b->getSpeaks() ? -1 : 1;
    }
    private function rankAdjudicators(\J\IV\Adjudicator $a, \J\IV\Adjudicator $b) {
        if ($a->getRank() == $b->getRank()) {
            return 0;
        }
        
        return $a->getRank() > $b->getRank() ? -1 : 1;
    }      
    public function rank() {
        $rankedTeams = array();
        uasort($this->teams, array($this, 'rankTeams'));
        uasort($this->adjudicators, array($this, 'rankAdjudicators'));
    }
    public function distributeToRooms($rank = true) {
        if($rank) {
            $this->rank();
        }
        
        $lastTeam = 0;
        $numTeams = count($this->teams);
        $numRooms = count($this->rooms);
        
        if($numTeams/8 > count($this->rooms)) {
            throw new Exception('Too Few Rooms!');
        }
        
        if($this->adjudicatorDistribution == self::Random) {
            shuffle($this->adjudicators);
        }
        
        $chairs = array_values(array_slice($this->adjudicators, 0, $numRooms));
        $numWings = count($this->adjudicators) - $numRooms;
        $wPerRoom = ceil($numWings/$numRooms);
        $i = 0;
        foreach($this->rooms as &$room) { 
            $room->setTeams(array_slice($this->teams, $i * 4, 4));
            $room->setChair($chairs[$i]);
            $room->setWings(
                array_slice($this->adjudicators, $numRooms + ($i * $wPerRoom), $wPerRoom)
            );

            $i++;
        }
        $last = end($this->rooms);
        $last = key($this->rooms);
        $prev = prev($this->rooms);
        $prev = key($this->rooms);
        $pPrev = prev($this->rooms);
        $pPrev = key($this->rooms);
        
        if(count($this->rooms[$last]->getWings()) < (int) ($wPerRoom/2)) {
            $moved = array_slice(array_reverse($this->rooms[$prev]->getWings()), 0, (int) ($wPerRoom/3));
            $moved = array_merge($moved, 
                        array_slice(array_reverse($this->rooms[$pPrev]->getWings()), 0, (int) ($wPerRoom/3))
                     );
            
            $this->rooms[$last]->setWings(array_merge($this->rooms[$last]->getWings(), $moved));
            $this->rooms[$prev]->setWings(array_diff($this->rooms[$prev]->getWings(), $moved));
            $this->rooms[$pPrev]->setWings(array_diff($this->rooms[$pPrev]->getWings(), $moved));
        }

    }
}