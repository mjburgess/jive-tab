<?php
namespace J\IV;

class Master {
    public static function start() {
        return X_IV_SCRIPT_START;
    }

    public static function toNow($wUnits = true) {
         return round((microtime(true) - X_IV_SCRIPT_START) * 1E3) . ($wUnits ? ' ms' : '');
    }

    public static function flash($msg = false, $type = FlashSuccess) {
        return flash($msg, $type);
    }
}

const FlashNotice = 'notice';
const FlashSuccess = 'success';
const FlashError = 'error';

function flash($msg = false, $type = FlashSuccess) {
        $ns = '__FLASH__';

        if($msg) {
            $_SESSION[$ns] = array($type, $msg);
            $return = $msg;
        } elseif(isset($_SESSION[$ns])) {
            $return = $_SESSION[$ns];
            unset($_SESSION[$ns]);
        } else {
            $return = '';
        }

        return $return;
}

abstract class Controller {
    private $variables;
        public function setVar($name, $value) {
            $this->variables[$name] = $value;
        }
        public function getVar($name) {
            return $this->variables[$name];
        }

    public static function handle($request, Storage $s = null) {
        list($ctlr, $action) = explode('_', $request);
        $controller = '\J\IV\\' . $ctlr . 'Controller';
        $controller = new $controller;

        $controller->display("$ctlr.$action", $controller->$action($s) ?: 'master', null, '.phtml');
    }

    public function display($_template, $_layout, $_folder = null, $_ext = '.phtml') {
        if(!$_folder) {
            $_folder = 'gui';
        }

        $_title = str_replace(array('Controller', __NAMESPACE__), '', get_class($this));

        extract((array) $this->variables);

        ob_start();
            require $_folder . DIRECTORY_SEPARATOR . $_template . $_ext;
        $_contents = ob_get_clean();

        require $_folder . DIRECTORY_SEPARATOR . $_layout . $_ext;
    }
}

