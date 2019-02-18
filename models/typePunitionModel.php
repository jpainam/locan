<?php

class typePunitionModel extends Model{
    protected $_table = "type_punitions";
    protected $_key = "IDTYPEPUNITION";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
