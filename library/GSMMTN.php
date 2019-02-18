<?php

/**
 * Design Pattern utilisee : SINGLETON
 * http://www.phptherightway.com/pages/Design-Patterns.html
 * 
 */
class GSMMTN extends GSM {

    protected $port = "COM2";

    /**
     *
     * @var GSM reference a une instance de la classe GSM
     */
    private static $instance = null;

    protected function __construct() {
        parent::__construct();
    }

    /**
     * Retourne l'instance de cette classe
     * @return GSM l'instance de la classe GSM
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new GSMMTN();
        }
        return self::$instance;
    }
    /**
     * private clone method afin d'eviter le clonage de la seule instance de cette classe
     * @return void
     */
   
    private function __clone() {
        
    }
     /**
     * methode de deserialisation private afin d'empecher toute 
     * deserialisation de l'unique instance de cette classe
     */
    private function __wakeup() {
        
    }

}
