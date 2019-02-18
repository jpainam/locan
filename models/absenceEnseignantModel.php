<?php

class absenceEnseignantModel extends Model {

    protected $_table = "absences_enseignants";
    protected $_key = "IDABSENCEENSEIGNANT";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir la liste des absences du jour
     * @param type $datejour
     * @return type
     */
    public function getAbsencesDuJour($datejour) {
        $query = "SELECT ab.*, pers.*, ens.*, mat.*, cl.*, "
                . "mat.LIBELLE AS MATIERELIBELLE, cl.LIBELLE AS CLASSELIBELLE, n.* "
                . "FROM `" . $this->_table . "` ab "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ab.PERSONNEL "
                . "LEFT JOIN enseignements ens ON ens.IDENSEIGNEMENT = ab.ENSEIGNEMENT "
                . "LEFT JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "LEFT JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "WHERE ab.DATEJOUR = :datejour "
                . "ORDER BY pers.NOM";
        return $this->query($query, ["datejour" => $datejour]);
    }

    public function getAbsencesByPeriode($datedebut, $datefin) {
        if (empty($datefin)) {
            $datefin = "2035-01-01";
        }
        $query = "SELECT ab.*, pers.*, ens.*, mat.*, cl.*, "
                . "mat.LIBELLE AS MATIERELIBELLE, cl.LIBELLE AS CLASSELIBELLE, n.* "
                . "FROM `" . $this->_table . "` ab "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ab.PERSONNEL "
                . "LEFT JOIN enseignements ens ON ens.IDENSEIGNEMENT = ab.ENSEIGNEMENT "
                . "LEFT JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "LEFT JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "WHERE ab.DATEJOUR BETWEEN :datedebut AND :datefin "
                . "ORDER BY pers.NOM";

        $params = ["datedebut" => $datedebut, "datefin" => $datefin];
        return $this->query($query, $params);
    }

    /**
     * Fonction utiliser dans enseignant/index onglet suivi
     * charge les absences de cette enseignant pour cette periode datedebut a datefin
     * @param type $datedebut
     * @param type $datefin
     * @param type $idenseignant
     * @return type
     */
    public function getAbsencesEnseignantByPeriode($datedebut, $datefin, $idenseignant) {
        $query = "SELECT a.*, p.* "
                . "FROM absences_enseignants a "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = a.PERSONNEL "
                . "WHERE a.PERSONNEL = :idpersonnel AND a.DATEJOUR BETWEEN :datedebut AND :datefin "
                . "ORDER BY ap.DATEJOUR ASC";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin, "idpersonnel" => $idenseignant]);
    }

    public function getResumesByPeriode($datedebut, $datefin = "") {
        if (empty($datefin)) {
            $datefin = "2035-01-01";
        }
        $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(RETARD))) AS SUMRETARD, SUM(NBHEURE) AS SUMABSENCE, "
                . "pers.* "
                . "FROM `" . $this->_table . "` ab "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ab.PERSONNEL "
                . "WHERE ab.DATEJOUR BETWEEN :datedebut AND :datefin "
                . "GROUP BY ab.PERSONNEL "
                . "ORDER BY pers.NOM ";

        $params = ["datedebut" => $datedebut, "datefin" => $datefin];
        return $this->query($query, $params);
    }
    /**
     * Utiliser dans l'impression de discipline individuelle
     * @param type $idpersonnel
     * @param type $datedebut
     * @param type $datefin
     * @return type
     */
    public function getResumesByPeriodeByEnseignant($idpersonnel, $datedebut, $datefin= ""){
         if (empty($datefin)) {
            $datefin = date("Y-m-d", strtotime("+1 day", strtotime($datedebut)));
        }
        $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(RETARD))) AS SUMRETARD, SUM(NBHEURE) AS SUMABSENCE "
                . "FROM `" . $this->_table . "` ab "
                . "WHERE ab.DATEJOUR BETWEEN :datedebut AND :datefin AND ab.PERSONNEL = :idpersonnel ";

        $params = ["datedebut" => $datedebut, "datefin" => $datefin, "idpersonnel" => $idpersonnel];
        return $this->row($query, $params);
    }

    public function getAbsencesByEnseignant($idpersonnel, $datedebut = "", $datefin = "") {
        if(empty($datedebut)){
            $datedebut = date("Y-m-d", time());
        }
        if(empty($datefin)){
            $datefin = "2035-01-01";
        }
        $query = "SELECT ab.*, cl.*, mat.*, n.* "
                . "FROM `" . $this->_table . "` ab "
                . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = ab.ENSEIGNEMENT "
                . "INNER JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "WHERE ab.PERSONNEL = :idpersonnel AND DATEJOUR BETWEEN :datedebut AND :datefin "
                . "ORDER BY ab.DATEJOUR DESC";
        return $this->query($query, ["idpersonnel" => $idpersonnel, "datedebut" => $datedebut, "datefin" => $datefin]);
    }

}
