<?php
namespace J\IV;

class SessionStore extends Storage {
    const Scope = 'X_IV';
    
    public function __construct() {
        $_SESSION[SessionStore::Scope] = array();
    }
    
    public function store($reference, $data) {
        $_SESSION[SessionStore::Scope][$reference] = $data;
    }
    
    public function update($reference, $data) {
        $this->store($reference, array_merge($this->retrieve($reference), $data));
    }
    
    public function retrieve($reference) {
        if(empty($_SESSION[SessionStore::Scope][$reference])) {
            return array();
        }
        
        return $_SESSION[SessionStore::Scope][$reference];
    }
    
    public function save($filename) {
        return file_put_contents(serialize($_SESSION[SessionStore::Scope]));
    }
    
    public function load($filename) {
        if($data = file_get_contents($filename)) {
            $_SESSION[SessionStore::Scope] = unserialize($data);
            
            return true;
        } else {
            return false;
        }
    }
}
