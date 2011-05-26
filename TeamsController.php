<?php
namespace J\IV;

class TeamsController extends Controller {
    public function index(Storage $db) {
        $this->setVar('teams', $db->retrieve(Storage::Teams));
    }
    public function add(Storage $db) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $team = new Team($_POST['name'], $_POST['representing'], 
                        new Speaker($_POST['firstName_1'], $_POST['lastName_1'], '', Speaker::Open),
                        new Speaker($_POST['firstName_2'], $_POST['lastName_2'], '', Speaker::Open));
                    
            Storage::add($db, Storage::Teams, $team->getTeamName(), $team);
        } elseif(isset($_GET['edit'])) {
            $entry = $db->retrieve(Storage::Teams, $_GET['edit']);            
            $this->setVar('entry', $entry);
        }
    }
    public function edit(Storage $db) {
        if(isset($_GET['delete'])) {
            Storage::delete($db, Storage::Teams, $_GET['delete']);
        }
        
        $this->setVar('teams', $db->retrieve(Storage::Teams));
    }
}