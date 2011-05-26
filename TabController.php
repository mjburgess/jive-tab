<?php
namespace J\IV;

class TabController extends Controller {
    public function test() {
        $T = new TabTest(10);
        $this->setVar('csvTeams', $T->csvTeams(4));
        $this->setVar('tabAvg1', $T->getTab()->averageSpeaks());
        $this->setVar('csvRooms', $T->csvRooms());
        $this->setVar('tabAvg2', $T->getTab()->averageSpeaks());
    }
    
    public function summary() {
        
    }
    
    public function speaks(Storage $db) {
        $this->setVar('teams', $db->retrieve(Storage::Teams));
        if(isset($_POST['Speaks'])) {
            $speaks = $_POST['Speaks'];
            $teams = $db->retrieve(Storage::Teams);
            foreach($teams as $name => $team) {
                if(isset($speaks[$name . '1'])) {
                    $team->setSpeaks($speaks[$name . '1'], $speaks[$name . '2']);
                }
            }
            $db->store(Storage::Teams, $teams);
        }
    }
    
    public function publish() {
        
    }
    
    public function options(Storage $db) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($db->store(Storage::Options, array('competitionName' => $_POST['competitionName']))) {
                flash('Competition Name Saved');
            } else {
                flash('Saving failed');
            }
            
        }
    }
    
    public function distribute(Storage $db) {
        $O = $db->retrieve(Storage::Options);
        $O = isset($O['distribution']) ? $O['distribution'] : null;
        
        $T = new Tab($db->retrieve(Storage::Rooms), 
                        $db->retrieve(Storage::Teams),
                        $db->retrieve(Storage::Adjudicators), $O);
        $T->distributeToRooms();
        
        $db->store(Storage::Rooms, $T->getRooms());
        
        $this->setVar('rooms', $T->getRooms());
    }
}