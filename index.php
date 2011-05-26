<?php
namespace J\IV;

session_start();

define('X_IV_SCRIPT_START', microtime(true));

spl_autoload_register(function ($classname) {
    require ucfirst(str_replace(__NAMESPACE__ .'\\', '', $classname) . '.php');
});

Controller::handle (
    empty($_GET['x']) ? 'home_index' : $_GET['x'],
    new FileStore()
);