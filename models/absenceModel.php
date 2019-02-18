<?php

class absenceModel extends Model {

    protected $_table = "absences";
    protected $_key = "IDABSENCE";

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

        $query = "SELECT a.*, ap.*, e.*, j.* "
                . "FROM `" . $this->_table . "` a "
                . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL "
                . "INNER JOIN eleves e ON e.IDELEVE = a.ELEVE "
                . "LEFT JOIN justifications j ON j.IDJUSTIFICATION = a.JUSTIFIER "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT p.*, e.*, a.* "
                . "FROM `" . $this->_table . "` p "
                . "LEFT JOIN appels a ON a.IDAPPEL = p.IDAPPEL "
                . "LEFT JOIN eleves e ON e.IDELEVE = p.IDELEVE "
                . "WHERE $str";

        return $this->query($query, $params);
    }

    /**
     * Pour un appel donnee, renvoie la liste des eleves 
     * ainsi que leur etat respectif
     * @param type $idappel
     */
    public function getAbsences($idappel) {
        $query = "SELECT a.*, e.* "
                . "FROM absences a "
                . "LEFT JOIN eleves e ON a.ELEVE = e.IDELEVE AND a.APPEL = :idappel "
                . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacad "
                . "ORDER BY e.NOM ";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], "idappel" => $idappel]);
    }
    /**
     * 
     * @param type $ideleve
     * @param type $idappel
     * @return type
     */
    public function getAbsencesEleveByAppel($ideleve, $idappel) {
        $query = "SELECT a.* "
                . "FROM absences a "
                . "WHERE a.APPEL = :appel AND a.ELEVE = :eleve "
                . "ORDER BY a.HORAIRE";

        return $this->query($query, ["appel" => $idappel,
                    "eleve" => $ideleve]);
    }

    /**
     * Obtenir la liste des absences pour cet tranche de date
     * @param type $datedebut
     * @param type $datefin
     * @param type $idclasse
     */
    public function getAbsencesByPeriode($datedebut, $datefin, $idclasse = "") {
        if (empty($idclasse)) {
            $query = "SELECT a.*, e.*, ap.* "
                    . "FROM absences a "
                    . "LEFT JOIN eleves e ON a.ELEVE = e.IDELEVE "
                    . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL AND (ap.DATEJOUR BETWEEN :datedebut AND :datefin) "
                    . "ORDER BY ap.DATEJOUR ASC";
            return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin]);
        } else {
            $query = "SELECT a.*, e.*, ap.* "
                    . "FROM absences a "
                    . "LEFT JOIN eleves e ON a.ELEVE = e.IDELEVE "
                    . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL AND (ap.DATEJOUR BETWEEN :datedebut AND :datefin) "
                    . "AND ap.CLASSE = :idclasse "
                    . "ORDER BY e.NOM ";

            return $this->query($query, ["idclasse" => $idclasse, "datedebut" => $datedebut,
                        "datefin" => $datefin]);
        }
    }

    /**
     * Fonction utiliser dans appel/suivi et donc la methode ajax est ajaxsuivi
     * charge les absences de cette eleve pour cette periode datedebut a datefin
     * @param type $datedebut
     * @param type $datefin
     * @param type $ideleve
     * @return type
     */
    public function getAbsencesEleveByPeriode($datedebut, $datefin, $ideleve) {
        $query = "SELECT a.*, e.*, ap.* "
                . "FROM absences a "
                . "INNER JOIN eleves e ON e.IDELEVE = a.ELEVE "
                . "INNER JOIN appels ap ON ap.IDAPPEL = a.APPEL AND (ap.DATEJOUR BETWEEN :datedebut AND :datefin) "
                . "WHERE a.ELEVE = :eleve "
                . "ORDER BY ap.DATEJOUR ASC";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin, "eleve" => $ideleve]);
    }

    /**
     * Met a jour cette absence en se basant 
     * sur un intervalle de date 
     * utiliser dans la methode justifierperiode du controlleur appel
     * Permet de justifier l'eleve sur un intervalle de valeurm
     * Cette fonction est appelle apre avoir inserer la justification en question
     * @param type $datedebut
     * @param type $datefin
     * @param type $idclasse
     * @param type $ideleve
     * @param type $justifier id de la justification precedemment inserer
     */
    public function updateJustifierByPeriode($datedebut, $datefin, $idclasse, $ideleve, $justifier) {
        $query = "UPDATE absences SET JUSTIFIER = :justifier "
                . "WHERE absences.ELEVE = :ideleve AND "
                . "absences.APPEL IN (SELECT ap.IDAPPEL "
                . "FROM appels ap "
                . "WHERE ap.CLASSE = :classe "
                . "AND ap.DATEJOUR BETWEEN :datedebut AND :datefin)";

        $params = ["justifier" => $justifier,
            "ideleve" => $ideleve,
            "classe" => $idclasse,
            "datedebut" => $datedebut,
            "datefin" => $datefin];
        return $this->query($query, $params);
    }

}
