<?php

class appelModel extends Model {

    protected $_table = "appels";
    protected $_key = "IDAPPEL";

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

        $query = "SELECT a.*, c.*, p1.NOM AS NOMREALISATEUR, p1.PRENOM AS PRENOMREALISATEUR, "
                . "p2.NOM AS NOMMODIFICATEUR, p2.PRENOM AS PRENOMMODIFICATEUR, n.* "
                . "FROM `" . $this->_table . "` a "
                . "INNER JOIN classes c ON c.IDCLASSE = a.CLASSE "
                . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                . "LEFT JOIN personnels p1 ON p1.IDPERSONNEL = a.REALISERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = a.MODIFIERPAR "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    /**
     * Renvoie la liste des appels de cette classe
     * realise pendant ce jour
     * @param type $idclasse
     * @param type $datejour
     */
    public function getAppels($idclasse, $datejour) {
        $query = "SELECT a.*, ap.* "
                . "FROM absences a "
                . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL AND ap.CLASSE = :idclasse AND ap.DATEJOUR = :datejour";
        return $this->query($query, ["idclasse" => $idclasse, "datejour" => $datejour]);
    }

    /**
     * Renvoi pour un appel donnee, la liste des 
     * eleve inscrit, et ceux qui etai absent et present ce jour d'appel
     * @param type $idappel
     */
    public function getListeAppel($idappel) {
        $query = "SELECT e.*, a.* "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacad "
                . "LEFT JOIN absences a ON a.ELEVE = e.IDELEVE AND a.APPEL = :idappel "
                . "ORDER BY e.NOM ";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], "idappel" => $idappel]);
    }

    /**
     * Verrouiller tous les appels de cette periode
     * @param type $datedebut
     * @param type $datefin
     * @return type
     */
    public function lockAppelsByPeriode($datedebut, $datefin) {
        $query = "UPDATE `" . $this->_table . "` "
                . "SET VERROUILLER = 1 "
                . "WHERE DATEJOUR BETWEEN :datedebut AND :datefin";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin]);
    }

    /**
     * Deverrouiller tous les appels de cette periode
     * @param type $idsequence
     * @return type
     */
    public function unlockAppelsByPeriode($datedebut, $datefin) {
        $query = "UPDATE `" . $this->_table . "` "
                . "SET VERROUILLER = 0 "
                . "WHERE DATEJOUR BETWEEN :datedebut AND :datefin";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin]);
    }

}
