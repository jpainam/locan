<?php
class paysModel extends Model{
    protected  $_table = "pays";
    protected $_key = "IDPAYS";
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Libelle a afficher dans les combo box;
     * Chaque model qui doit etre afficher dans le combo doit
     * definir sa methode libelle
     * @return string
     */
    public function getLibelle(){
        return "PAYS";
    }
}
