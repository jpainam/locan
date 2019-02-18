<?php

class arrondissementModel extends Model{
    protected $_table = "arrondissements";
    protected $_key = "IDARRONDISSEMENT";
    
    public function __construct() {
        parent::__construct();
    }
    public function getLibelle(){
        return "LIBELLE";
    }
    
}
