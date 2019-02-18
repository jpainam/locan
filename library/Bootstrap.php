<?php

require_once(ROOT . DS . 'config' . DS . 'config.php');

require_once(ROOT . DS . 'library' . DS . 'Functions.php');
# Identique a la premiere, juste pour limiter la taille du premier fichier
require_once(ROOT . DS . 'library' . DS . 'Functions2.php');
require_once(ROOT . DS . 'library' . DS . 'Functions3.php');

mb_internal_encoding('UTF-8');

function __autoload($className) {
    if (file_exists(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'models' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.php');
    }else if(file_exists(ROOT . DS . 'entites' . DS . strtolower($className) . '.php')){
        require_once(ROOT . DS . 'entites' . DS . strtolower($className) . '.php');
    }else if(file_exists(ROOT . DS . 'library' . DS . 'tcpdf' . DS . strtolower($className) . '.php')){
        require_once(ROOT . DS . 'library' . DS . 'tcpdf' . DS . strtolower($className) . '.php');
    } else {
        //Une erreur grave
        die("Error: Class $className introuvable");
    }
    
}

Router::route();