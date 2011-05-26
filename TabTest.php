<?php
namespace J\IV;

class TabTest {
    private $tab;
        public function getTab() {
            return $this->tab;
        }
    private $numRooms;
    
    public function __construct($numRooms) {
        $this->tab = new Tab();
        $this->setUpIV($numRooms);
    }
    
    public function allRooms() {
        $rtn = '';
        foreach($this->tab->getRooms() as $room) {
            $rtn .= (string) $room;
        }
        
        return $rtn;
    }
    
    public function csvRooms($numRounds = 5) {
        $rtn = "Room\tRound\tT1\tT2\tT3\tT4\n";
        for($r = 0; $r < $numRounds; $r++) {
            $this->completeRound();
            foreach($this->tab->getRooms() as $room) {
                $out = array($room->getID(), $r);                
                foreach($room->getTeams() as $team) {
                    $out[] = round($team->getAverageSpeaks());
                }
                $rtn .= implode("\t", $out) . "\n";
            }
        }
        
        return $rtn;
    }
    
    private function rankTeams($a, $b) {
        if (array_sum($a) == array_sum($b)) {
            return 0;
        }
        return (array_sum($a) < array_sum($b)) ? -1 : 1;
    }
    
    public function csvTeams($numRounds = 5) {
        
        $teams = array();
        for($r = 0; $r < $numRounds; $r++) {
            $this->completeRound();
            foreach($this->tab->getTeams() as $team) {
                $teams[$team->getTeamName()][] =  $team->getAverageSpeaks();
            }
        }
        
        uasort($teams, array($this, 'rankTeams'));
        
        $rtn = '';
        foreach($teams as $name => $team) {
            $out = array($name);
            foreach($team as $round) {
                $out[] = round($round);
            }
            
            $rtn .= implode("\t", $out) . "\n";
        }
        
        return $rtn;
    }
    
    public function completeRound() {
        for($i = 0; $i < 4 * $this->numRooms; $i++) {
            $team = $this->tab->getTeam("Team(:$i)");
            $last = $team->getAverageSpeaks();

            if($last == 0) {
                $spk  = 0.714 * rand(75, 85);
                $spk += 0.286 * rand(50, 75);
                $spk = round($spk);
            } else {
                $dev  = rand(0,10) * rand(6, 10);
                $dev += rand(0,90) * rand(3, 6);
                $dev += rand(0,100) * rand(0, 3);
                $dev = round($dev * 0.01);
                $spk = round($last + (rand(0,1) ? $dev : -$dev));
            }

            $team->setSpeaks($spk, $spk);
        }
        
        $this->tab->distributeToRooms();
    }
    
    public function setUpIV($numRooms) {
        $this->numRooms = $numRooms;
        
        for($i = 0; $i < $numRooms; $i++) {
            $this->tab->addRoom(new Room("Room($i)", "Floor($i)"));
        }
        
        for($i = 0; $i < 4 * $numRooms; $i++) {
            $this->tab->addAdjudicator(new Adjudicator("Adjudicator", "$i", "Uni($i)", $i));
            
            if($i % 5) {
                $this->tab->addAdjudicator(new Adjudicator("Adjudicator", "$i+", "Uni($i)", $i));
            }
            
            $this->tab->addTeam(
                new Team("Team(:$i)", "Uni($i)", 
                        new Speaker("First[$i]", "Last[$i]", "Uni($i)", Speaker::UnderGrad),
                        new Speaker("First($i)", "Last($i)", "Uni($i)", Speaker::UnderGrad)
                )
            );
        }
    }
}