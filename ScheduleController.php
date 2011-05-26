<?php
namespace J\IV;

class ScheduleController extends Controller {
    public function index(Storage $db) {
        $this->setVar('schedule', $db->retrieve(Storage::Schedule));
    }
    public function add(Storage $db) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $event = new Event($_POST['name'], $_POST['time'], $_POST['location'], $_POST['type']);
            Storage::add($db, Storage::Schedule, $event->getPosition(), $event);
        } elseif(isset($_GET['edit'])) {
            $entry = $db->retrieve(Storage::Schedule, $_GET['edit']);
            $this->setVar('entry', $entry);
        }
    }
    public function edit(Storage $db) {
        if(isset($_GET['delete'])) {
            Storage::delete($db, $_GET['delete']);
        }

        $this->setVar('schedule', $db->retrieve(Storage::Schedule));
    }
}