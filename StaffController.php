<?php
namespace J\IV;

class StaffController extends Controller {
    public function index() {
        
    }
    
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $staff = new Staff($_POST['firstName'], $_POST['lastName'], '');
            Storage::add($db, Storage::Staff, $staff->getName(), $staff);
        }
    }
    
    public function edit(Storage $db) {
        if(isset($_GET['delete'])) {
            Storage::delete($db, Storage::Staff, $_GET['delete']);
        }
        
        $this->setVar('teams', $db->retrieve(Storage::Staff));
    }
}