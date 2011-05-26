<?php
namespace J\IV;

abstract class Storage {
    const Rooms = 1;
    const Teams = 2;
    const Adjudicators = 3;
    const Options = 4;
    const Schedule = 5;

    abstract function store($reference, $data);
    abstract function update($reference, $data);
    abstract function retrieve($reference, $subref = null);
    abstract function remove($reference, $subindex);

    abstract function save();
    abstract function load($dbName);

    abstract function fetchAll();

    public function storeTab(\J\IV\Tab $t){
        $this->store(Storage::Rooms, $t->getRooms());
        $this->store(Storage::Teams, $t->getTeams());
        $this->store(Storage::Adjudicators, $t->getAdjudicators());
        $this->store(Storage::Distribution, $t->getAdjudicatorDistribution());
    }

    public function loadTab() {
        return new Tab(
                $this->retrieve(Storage::Rooms), $this->retrieve(Storage::Teams),
                $this->retrieve(Storage::Adjudicators), $this->retrieve(Storage::Distribution)
        );
    }

    public static function add(Storage $db, $reference, $index, $value) {
        if($db->update($reference, array($index => $value))) {
            flash($index . ' added successfully!');
        } else {
            flash('Failed to add ' . $index . '!');
        }
    }

    public static function delete(Storage $db, $reference, $index) {
        if($db->remove($reference, $index)) {
            flash($index . ' deleted successfully!');
        } else {
            flash('Failed to delete ' . $index . '!');
        }
    }
}