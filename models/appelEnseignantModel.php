<?php

class appelEnseignantModel extends Model {
    protected $_table = "appels_enseignants";
    protected $_key = "IDAPPELENSEIGNANT";
    
    public function __construct() {
        parent::__construct();
    }
    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);

        
        $query = "SELECT ap.*, p.NOM AS NOMREALISATEUR, p.PRENOM AS PRENOMREALISATEUR, c.* "
                . "FROM `" . $this->_table . "` ap "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = ap.REALISERPAR "
                . "INNER JOIN classes c ON c.IDCLASSE = ap.CLASSE "
                . "WHERE $str";
        return $this->row($query, $params);
    }
}
