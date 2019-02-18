<?php

class programmationModel extends Model {

    protected $_table = "programmations";
    protected $_key = "IDPROGRAMMATION";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir la programmation de cette enseignement
     * @param type $idenseignement
     */
    public function getProgrammationsByEnseignement($idenseignement) {
        $query = "SELECT pr.*, lec.*, lec.TITRE AS TITRELECON, chap.*, chap.TITRE AS TITRECHAPITRE, act.*, act.TITRE AS TITREACTIVITE, "
                . "ens.*, seq.* "
                . "FROM `" . $this->_table . "` pr "
                . "INNER JOIN lecons lec ON lec.IDLECON = pr.LECON "
                . "INNER JOIN chapitres chap ON chap.IDCHAPITRE = lec.CHAPITRE "
                . "LEFT JOIN sequences seq ON seq.IDSEQUENCE = chap.SEQUENCE "
                . "INNER JOIN activites act ON act.IDACTIVITE = chap.ACTIVITE AND act.ENSEIGNEMENT = :idenseignement "
                . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = act.ENSEIGNEMENT "
                . "ORDER BY seq.ORDRE ASC, pr.DATEFAIT DESC";
        return $this->query($query, ["idenseignement" => $idenseignement]);
    }

    /**
     * Supprimer les programmation de cet enseignement
     * @param type $idenseignement
     */
    public function deleteProgrammationsByEnseignement($idenseignement) {
        $query = "DELETE FROM `" . $this->_table . "` "
                . "WHERE LECON IN ("
                . "SELECT lec.IDLECON FROM lecons lec "
                . "INNER JOIN chapitres chap ON chap.IDCHAPITRE = lec.CHAPITRE "
                . "INNER JOIN activites act ON act.IDACTIVITE = chap.ACTIVITE AND act.ENSEIGNEMENT = :idenseignement)";
        return $this->query($query, ["idenseignement" => $idenseignement]);
    }

}
