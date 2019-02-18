<?php

class motifsortieModel extends Model{
    
    protected $_table = "motifsortie";
    protected $_key = "IDMOTIF";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
   
    
}
