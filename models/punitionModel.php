<?php

class punitionModel extends Model {

    protected $_table = "punitions";
    protected $_key = "IDPUNITION";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "MOTIF";
    }

    public function selectAll() {
        $query = "SELECT p.*, e.*, t.*, CONCAT(pe.NOM,' ',pe.PRENOM) AS PUNISSEUR "
                . "FROM punitions p "
                . "LEFT JOIN eleves e ON e.IDELEVE = p.ELEVE "
                . "LEFT JOIN type_punitions t ON t.IDTYPEPUNITION = p.TYPEPUNITION "
                . "LEFT JOIN personnels pe ON pe.IDPERSONNEL = p.PUNIPAR "
                . "ORDER BY DATEPUNITION";
        return $this->query($query);
    }
    
    public function get($id){
         $query = "SELECT p.*, e.*, t.*, CONCAT(pe.NOM,' ',pe.PRENOM) AS PUNISSEUR "
                . "FROM punitions p "
                . "LEFT JOIN eleves e ON e.IDELEVE = p.ELEVE "
                . "LEFT JOIN type_punitions t ON t.IDTYPEPUNITION = p.TYPEPUNITION "
                . "LEFT JOIN personnels pe ON pe.IDPERSONNEL = p.PUNIPAR "
                . "WHERE p.IDPUNITION = :idpunition";
         return $this->row($query, ["idpunition" => $id]);
    }
    
    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT p.*, e.*, t.*, CONCAT(pe.NOM,' ',pe.PRENOM) AS PUNISSEUR "
                . "FROM punitions p "
                . "LEFT JOIN eleves e ON e.IDELEVE = p.ELEVE "
                . "LEFT JOIN type_punitions t ON t.IDTYPEPUNITION = p.TYPEPUNITION "
                . "LEFT JOIN personnels pe ON pe.IDPERSONNEL = p.PUNIPAR "
                . "WHERE $str "
                . "ORDER BY DATEPUNITION";
        return $this->query($query, $params);
    }

}
