<?php

class activiteModel extends Model{
    protected $_table = "activites";
    protected  $_key = "IDACTIVITE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "DESCRIPTION";
    }
}
