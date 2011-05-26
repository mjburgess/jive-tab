<?php
namespace J\IV;

class AdjudicatorsController extends Controller {
    public function index(Storage $db) {
        $this->setVar('adjudicators', $db->retrieve(Storage::Adjudicators));
    }
    
    public function add(Storage $db) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ad = new Adjudicator($_POST['firstName'], $_POST['lastName'], 
                                    $_POST['university'], $_POST['rank']);
            Storage::add($db, Storage::Adjudicators, $ad->getName(), $ad);
        } elseif(isset($_GET['edit'])) {
            $entry = $db->retrieve(Storage::Adjudicators, $_GET['edit']);
            $this->setVar('entry', $entry);
        }
    }
    public function edit(Storage $db) {
        if(isset($_GET['delete'])) {
            Storage::delete($db, Storage::Adjudicators, $_GET['delete']);
        }
        
        $this->setVar('adjudicators', $db->retrieve(Storage::Adjudicators));
    }
}