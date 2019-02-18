<?php
class justificationModel extends Model{
    protected $_table = "justifications";
    protected  $_key = "IDJUSTIFICATION";


    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "MOTIF";
    }
    /**
     * Supprime les justification des absences compris entre 
     * date debut et date fin,
     * @param type $datedebut
     * @param type $datefin 
     * Function utiliser pour la justification par periode dans appel/justification
     */
    public function deleteByPeriode($datedebut, $datefin, $classe, $eleve){
        $query = "DELETE FROM `" . $this->_table ."` "
                . "WHERE ".$this->_key." IN ("
                        . "SELECT a.JUSTIFIER FROM absences a "
                        . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL "
                            . "AND ap.DATEJOUR BETWEEN :datedebut AND :datefin AND ap.CLASSE = :classe "
                        . "WHERE a.ELEVE = :ideleve)";
        $params = ["datedebut" => $datedebut, 
            "datefin" => $datefin, 
            "classe" => $classe, 
            "ideleve" => $eleve];
        $this->query($query, $params);
    }
    
    public function findSingleRowBy($conditions = array()) {
         $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        
        $query = "SELECT j.*, p.* "
                . "FROM `" . $this->_table ."` j "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = j.REALISERPAR "
                . "WHERE $str";
        return $this->row($query, $params);
    }
  
}
