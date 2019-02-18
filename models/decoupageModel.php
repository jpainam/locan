<?php

class decoupageModel extends Model{
    protected  $_table = "decoupage";
    protected  $_key = "IDDECOUPAGE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
