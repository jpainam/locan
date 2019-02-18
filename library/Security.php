<?php

class Security {

   
    public function sanitize_globals() {
        
    }

    public function get($key = "") {
        /*if (empty($key)) {
            $array = array();
            foreach ($_GET as $key => $val) {
                $array[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $array;
        }*/
        if(is_array($_GET[$key])){
            $array = array();
            foreach ($_GET as $key => $val) {
                $array[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $array;
        }
        return filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function post($key = "") {
        /*if (empty($key)) {
            $array = array();
            foreach ($_POST as $key => $val) {
                $array[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $array;
        }*/
        
        if(is_array($_POST[$key])){
            $array = array();
            foreach ($_POST as $key => $val) {
                $array[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $array;
        }
        return filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function session($key) {
        //Ne marche et renvoi une erreur que INPUT_SESSION not yet implemented
        //return filter_input(INPUT_SESSION, $key, FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public function server($key = "") {
        return filter_input(INPUT_SERVER, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function file($key = "") {
        if (isset($_FILES[$key]) && !empty($_FILES[$key])) {
            return $_FILES[$key];
        } else {
            return false;
        }
        
    }

}
