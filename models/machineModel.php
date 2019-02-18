<?php

class machineModel extends Model{
    protected  $_table = "machines";
    protected  $_key = "IDMACHINE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
