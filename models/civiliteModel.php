<?php
class civiliteModel extends Model{

    protected $_table = "civilite";
    protected $_key = "CIVILITE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "CIVILITE";
    }
    
}
