<?php
class specialiteModel extends Model{
    protected $_table = "specialites";
    protected $_key = "IDSPECIALITE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
