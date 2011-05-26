<?php
namespace J\IV;

class FileStore extends Storage {
    private $db, $dbName;
        public function fetchAll() {
            return $this->db;
        }
        
    public function __construct($dbName = 'jiv.db') {
        $this->db = array();
        $this->dbName = $dbName;
        
        if(file_exists($dbName)) {
            $this->load($dbName);
        }
    }
    
    public function store($reference, $data) {
        $this->db[$reference] = $data;
        return $this->save();
    }
    
    public function remove($reference, $subindex) {
        unset($this->db[$reference][$subindex]);
        return $this->save();
    }
    
    public function update($reference, $data) {
        return $this->store($reference, array_merge($this->retrieve($reference), $data));
    }
    
    public function retrieve($reference, $subref = null) {
        if(empty($this->db[$reference])) {
            return array();
        }
        
        if($subref && empty($this->db[$reference][$subref])) {
            return array();
        }
        
        return $subref ? $this->db[$reference][$subref] : $this->db[$reference];
    }
    
    public function save() {
        return file_put_contents($this->dbName, serialize($this->db));
    }
    
    public function load($dbName) {
        $this->db = unserialize(file_get_contents($dbName));
    }
}