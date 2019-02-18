<?php

class classeparametreModel extends Model {

    protected $_table = "classes_parametres";
    protected $_key = "IDPARAMETRE";

    public function __construct() {
        parent::__construct();
    }

    /**
     * 1 = prof principale
     * 2 = cpe principale
     * 3 = resp administratif
     * @param type $action
     */
    public function deletePrincipale($action, $idparams) {
        switch ($action) {
            case 1:
                $query = "UPDATE classes_parametres SET PROFPRINCIPALE = NULL WHERE IDPARAMETRE = :idparams";
                break;
            case 2:
                $query = "UPDATE classes_parametres SET CPEPRINCIPALE = NULL WHERE IDPARAMETRE = :idparams";
                break;
            case 3:
                $query = "UPDATE classes_parametres SET RESPADMINISTRATIF = NULL WHERE IDPARAMETRE = :idparams";
                break;
        }
        return $this->query($query, ["idparams" => $idparams]);
    }
    
    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT cp.*, c.*, p.NOM AS NOMPRINCIPALE, p.PRENOM as PRENOMPRINCIPALE, "
                . "r.NOM as NOMRESPONSABLE, r.PRENOM as PRENOMRESPONSABLE, "
                . "pp.NOM AS NOMADMIN, pp.PRENOM as PRENOMADMIN "
                . "FROM classes_parametres cp "
                . "LEFT JOIN classes c ON c.IDCLASSE = cp.CLASSE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = cp.PROFPRINCIPALE "
                . "LEFT JOIN responsables r ON r.IDRESPONSABLE = cp.CPEPRINCIPALE "
                . "LEFT JOIN personnels pp ON pp.IDPERSONNEL = cp.RESPADMINISTRATIF "
                . "WHERE $str";
        return $this->row($query, $params);
    }

}
