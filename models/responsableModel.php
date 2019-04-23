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
    
    /**
     * Liste des eleves dont @param  est responsable
     * @param type $ideleve
     * @return type
     */
     public function getEleves($idresponsable) {
        $query = "SELECT e.*, re.*"
                . "FROM eleves e "
                . "LEFT JOIN responsable_eleve re ON re.IDELEVE = e.IDELEVE "
                . "WHERE re.IDRESPONSABLE = :idresponsable ";
        return $this->query($query, ["idresponsable" => $idresponsable]);
    }
}
