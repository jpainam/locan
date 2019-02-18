<?php

class recapitulatifModel extends Model {

    protected $_table = "recapitulatifs";
    protected $_key = "IDRECAPITULATIF";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir le bulletin recapitulatif des eleves de cette classe, a cette 
     * sequence
     * @param type $idclasse
     * @param type $idsequence
     */
    public function getRecapitulatifs($idclasse, $idsequence, $ideleve = "") {
        if (empty($ideleve)) {
            $query = "SELECT r.*, rb.*, seq.* "
                    . "FROM `" . $this->_table . "` r "
                    . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                    . "AND rb.CLASSE = :idclasse  "
                    . "INNER JOIN sequences seq ON seq.IDSEQUENCE = rb.SEQUENCE "
                    . "WHERE rb.SEQUENCE <> :idsequence AND seq.ORDRE < ("
                    . "SELECT ORDRE FROM sequences WHERE IDSEQUENCE = :idsequence1) "
                    . "ORDER BY seq.ORDRE ASC";
            return $this->query($query, ["idclasse" => $idclasse, "idsequence" => $idsequence,
                        "idsequence1" => $idsequence]);
        } else {
            $query = "SELECT r.*, rb.*, seq.* "
                    . "FROM `" . $this->_table . "` r "
                    . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                    . "AND rb.CLASSE = :idclasse  "
                    . "INNER JOIN sequences seq ON seq.IDSEQUENCE = rb.SEQUENCE "
                    . "WHERE r.ELEVE = :ideleve AND rb.SEQUENCE <> :idsequence AND seq.ORDRE < ("
                    . "SELECT ORDRE FROM sequences WHERE IDSEQUENCE = :idsequence1) "
                    . "ORDER BY seq.ORDRE ASC";
            return $this->query($query, ["idclasse" => $idclasse, "ideleve" => $ideleve,
                        "idsequence" => $idsequence, "idsequence1" => $idsequence]);
        }
    }

    /**
     * Obtenir le recapitulatif precedement 
     * @param int $idclasse
     * @param int $idsequence
     */
    public function getRecapitulatifBulletin($idclasse, $idsequence) {
        $query = "SELECT r.*, rb.*, seq.* "
                . "FROM `" . $this->_table . "` r "
                . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                . "INNER JOIN sequences seq ON seq.IDSEQUENCE = rb.SEQUENCE "
                . "WHERE rb.CLASSE = :idclasse AND rb.SEQUENCE = :sequence "
                . "ORDER BY r.ELEVE";
        return $this->query($query, ["idclasse" => $idclasse, "sequence" => $idsequence]);
    }

    /**
     * 
     * @param type $idclasse
     * @param array $sequences. Tableau des idsequence du trimestre
     */
    public function getRecapitulatifTrimestre($idclasse, $sequences) {
        return null;
    }

    /**
     * Utiliser dans recapitulatif des resultat dans la rubrique NOte,
     * 
     * @param type $idclasse
     * @param type $idsequence
     */
    public function getSyntheseResultat($idclasse, $idsequence) {
        $query = "SELECT r.*, rb.*, seq.*, el.* "
                . "FROM `" . $this->_table . "` r "
                . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                . "INNER JOIN eleves el ON el.IDELEVE = r.ELEVE "
                . "INNER JOIN sequences seq ON seq.IDSEQUENCE = rb.SEQUENCE "
                . "WHERE rb.CLASSE = :idclasse AND rb.SEQUENCE = :sequence "
                . "ORDER BY r.MOYENNE DESC";

        return $this->query($query, ["idclasse" => $idclasse, "sequence" => $idsequence]);
    }

    /**
     * Identique au precedent mais utiliser pour le trimestre
     * @param type $idclasse
     * @param type $array_of_sequences
     * @return type
     */
    public function getSyntheseResultatTrimestre($idclasse, $array_of_sequences) {
        $query = "SELECT (t1.MOY1 + t2.MOY2)/2 AS MOYENNE, t1.SEXE, t1.ELEVE, t1.NOM, t1.PRENOM "
                . "FROM (SELECT r.*, MOYENNE AS MOY1, el.SEXE, el.NOM, el.PRENOM FROM recapitulatifs r "
                    . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                        . "AND rb.SEQUENCE = :seq1 AND rb.CLASSE = :idclasse1 "
                    . "INNER JOIN eleves el ON el.IDELEVE = r.ELEVE ) t1 ,"
                    . "(SELECT r.*, MOYENNE AS MOY2 FROM recapitulatifs r "
                    . "INNER JOIN recapitulatifs_bulletins rb ON rb.IDRECAPITULATIFBULLETIN = r.RECAPITULATIFBULLETIN "
                        . "AND rb.SEQUENCE = :seq2 AND rb.CLASSE = :idclasse2) t2 "
                . "WHERE t1.ELEVE = t2.ELEVE "
                . "ORDER BY MOYENNE DESC";

        return $this->query($query, ["idclasse1" => $idclasse, "idclasse2" => $idclasse,
            "seq1" => $array_of_sequences[0],
                    "seq2" => $array_of_sequences[1]]);
    }

}
