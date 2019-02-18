<?php

class compteEleveModel extends Model{
    protected  $_table = "comptes_eleves";
    protected  $_key = "IDCOMPTE";
    
    public function __construct() {
        parent::__construct();
    }
    public function selectAll() {
        $query = "SELECT c.*, el.* "
                . "FROM `" . $this->_table . "` c "
                . "INNER JOIN eleves el ON el.IDELEVE = c.ELEVE "
                . "ORDER BY el.NOM";
        return $this->query($query);
    }
    
    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT c.*, el.* "
                . "FROM `" . $this->_table . "` c "
                . "INNER JOIN eleves el ON el.IDELEVE = c.ELEVE "
                . "WHERE $str ";
        return $this->row($query, $params);
    }
    /**
     * Obtenir la liste des compte eleves inscrit dans cette classe
     * @param type $idclasse
     */
    public function getComptesByClasse($idclasse){
        $query = "SELECT ce.*, el.* "
                . "FROM `" . $this->_table . "` ce "
                . "INNER JOIN eleves el ON el.IDELEVE = ce.ELEVE "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :idclasse "
                . "ORDER BY el.NOM";
        
        return $this->query($query, ["idclasse" => $idclasse]);
    }
}
