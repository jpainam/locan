<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EleveexclusModel
 *
 * @author JP
 */
class EleveExclusModel extends Model{
    protected $_table = "eleve_exclus";
    protected $_key = "IDELEVEEXCLUS";
    public function __construct() {
        parent::__construct();
    }
    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT ex.*, e.*, cl.*, niv.* "
                . "FROM `" . $this->_table . "` ex "
                . "INNER JOIN eleves e ON e.IDELEVE = ex.ELEVE "
                . "INNER JOIN inscription i ON i.IDELEVE = ex.ELEVE AND i.ANNEEACADEMIQUE = ex.PERIODE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU "
                . "WHERE $str";

        return $this->query($query, $params);
    }
    public function selectAll() {
        //$annee = $_SESSION['anneeacademique'];
        $query = "SELECT ee.*, el.* "
                . "FROM eleve_exclus ee "
                . "INNER JOIN eleves el ON el.IDELEVE = ee.ELEVE "
                //. "INNER JOIN inscription i on i.IDELEVE = ee.ELEVE and i.ANNEEACADEMIQUE = :annee "
                //. "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                //. "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU "
                . "ORDER BY el.NOM ASC";
        return $this->query($query);
    }
    public function getEleveExclusByClasse($idclasse){
        $annee = $_SESSION['anneeacademique'];
        $query = "SELECT ee.*, i.*, cl.*, niv.*, el.* "
                . "FROM eleve_exclus ee "
                . "INNER JOIN eleves el ON el.IDELEVE = ee.ELEVE "
                . "INNER JOIN inscription i on i.IDELEVE = ee.ELEVE and i.ANNEEACADEMIQUE = :annee "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU "
                . "WHERE cl.IDCLASSE = :idclasse "
                . "ORDER BY el.NOM ASC ";
        return $this->query($query, ["annee" => $annee, "idclasse" => $idclasse]);
    }
}
