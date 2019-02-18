<?php

class departementModel extends Model{
    protected  $_table = "departements";
    protected  $_key = "IDDEPARTEMENT";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
