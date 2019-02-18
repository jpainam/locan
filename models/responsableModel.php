<?php

class responsableModel extends Model{
    protected  $_table = "responsables";
    protected  $_key = "IDRESPONSABLE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function selectAll() {
        
        $query = "SELECT r.*, CONCAT(NOM, ' ', PRENOM) AS CNOM "
                . "FROM $this->_table r ORDER BY NOM";
        return $this->query($query);
    }
    
    public function getLibelle(){
        return "CNOM";
    }  
}
