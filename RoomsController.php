<?php
namespace J\IV;

class RoomsController extends Controller {
    public function index(Storage $db) {
        $this->setVar('rooms', $db->retrieve(Storage::Rooms));
    }
    
    public function add(Storage $db) {
        if(isset($_POST['id'])) {
            Storage::add($db, Storage::Rooms, 
                $_POST['id'], new Room($_POST['id'], $_POST['location']));
        } elseif(isset($_GET['edit'])) {
            $entry = $db->retrieve(Storage::Rooms, $_GET['edit']);
            $this->setVar('entry', $entry);
        }
    }
    
    public function edit(Storage $db) {
        if(isset($_GET['delete'])) {
            Storage::delete($db, $_GET['delete']);
        }
        
        $this->setVar('rooms', $db->retrieve(Storage::Rooms));
    }
}