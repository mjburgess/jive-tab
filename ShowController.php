<?php
namespace J\IV;

class ShowController extends Controller {
    public function useSlideTemplate($heading) {
        $this->setVar('_ca', 'Gayan');
        $this->setVar('_dcas', 'Michael & Michaela');
        $this->setVar('_convenor', 'James Wood');
        $this->setVar('_heading', $heading);
        
        return 'slide';
    }
    
    public function start(Storage $db) {
        $options = $db->retrieve(Storage::Options);
        $this->setVar('options', $options);

        return $this->useSlideTemplate('Start');
    }

    public function currentRound(Storage $db) {
        $thisRound = $_GET['r'];
        $thisTeam  = $_GET['t'];

        $rooms    = array_values($db->retrieve(Storage::Rooms));
        $schedule = $db->retrieve(Storage::Schedule);

        $rounds   = array();
        foreach($schedule as $event) {
            if($event->type == 'round') {
                $rounds[] = $event;
            }
        }

        $this->setVar('numRounds', count($rounds));
        $this->setVar('motion',    $round->getName());
        $this->setVar('teams',     array_slice($rooms->getTeams(), 4 * $thisRoom));

        return $this->useSlideTemplate('Round #');
    }

    public function schedule(Storage $db) {
        $options = $db->retrieve(Storage::Options);
        $this->setVar('options', $options);

        $schedule = $db->retrieve(Storage::Schedule);
        $this->setVar('schedule', $schedule);
        return $this->useSlideTemplate('Schedule');
    }
    public function staffList() {
        return $this->useSlideTemplate('Staff List');
    }
    public function register(Storage $db) {
        $teams = $db->retrieve(Storage::Teams);
        $this->setVar('teams', $teams);
        return $this->useSlideTemplate('Register');
    }
}