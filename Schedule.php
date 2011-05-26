<?php
namespace J\IV;

class Schedule  {
    private $events;
        public function setEvents(array $e) {
            $this->events = $e;
        }
        public function getEvents() {
            return $this->events;
        }
        public function addEvent(\X\Event $e) {
            $this->events[$e->getName()] = $e;
        }
        public function getEvent($name) {
            return $this->events[$name];
        }
        public function remove($name) {
            unset($this->events[$name]);
        }
}