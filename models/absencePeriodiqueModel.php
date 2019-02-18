<?php

class absencePeriodiqueModel extends Model {

    protected $_table = "absences_periodiques";
    protected $_key = "IDABSENCEPERIODIQUE";

    public function __construct() {
        parent::__construct();
    }

    public function getAbsencesPeriodique($idclasse, $sequence) {
        $query = "SELECT i.*, ap.*, ap.ABSENCE AS TOTALABS, "
                . "(ap.ABSENCE - ap.JUSTIFIER) AS ABSINJUST, "
                . "ap.JUSTIFIER AS ABSJUST, "
                . "ap.CONSIGNE AS CONSIGNE, ap.DECISION "
                . "FROM inscription i "
                . "LEFT JOIN absences_periodiques ap ON ap.ELEVE = i.IDELEVE AND ap.SEQUENCE = :sequence "
                . "AND ap.CLASSE = :idclasse2 "
                . "WHERE i.IDCLASSE = :idclasse1";
        return $this->query($query, ["idclasse1" => $idclasse, "idclasse2" => $idclasse,
                    "sequence" => $sequence]);
    }

    public function getAbsencesPeriodiqueByELeve($idclasse, $sequence, $ideleve) {
        $query = "SELECT i.*, ap.*, ap.ABSENCE AS TOTALABS, "
                . "(ap.ABSENCE - ap.JUSTIFIER) AS ABSINJUST, ap.JUSTIFIER AS ABSJUST, "
                . "ap.CONSIGNE AS CONSIGNE, ap.DECISION "
                . "FROM inscription i "
                . "LEFT JOIN absences_periodiques ap ON ap.ELEVE = i.IDELEVE AND ap.SEQUENCE = :sequence "
                . "AND ap.CLASSE = :idclasse2 "
                . "WHERE i.IDCLASSE = :idclasse1 AND i.IDELEVE = :ideleve2";
        return $this->row($query, ["idclasse1" => $idclasse, "idclasse2" => $idclasse,
                    "sequence" => $sequence, "ideleve2" => $ideleve]);
    }

    public function getAbsenceGlobalTrimestre($sequences = array()) {
        $query = "SELECT ELEVE, CLASSE, SUM(ABSENCE) AS ABSENCE, "
                . "SUM(JUSTIFIER) AS JUSTIFIER, "
                . "SUM(CONSIGNE) AS CONSIGNE "
                . "FROM `" . $this->_table . "` "
                . "WHERE SEQUENCE = :seq1 OR SEQUENCE = :seq2 "
                . "GROUP BY ELEVE";
        return $this->query($query, ["seq1" => $sequences[0], "seq2" => $sequences[1]]);
    }

    public function getAbsenceAnnuelle($idclasse, $anneecad) {
        $query = "SELECT i.*, ap.*, s.ORDRE AS ORDRESEQUENCE "
                . "FROM inscription i "
                . "INNER JOIN absences_periodiques ap ON ap.ELEVE = i.IDELEVE "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = ap.SEQUENCE "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE "
                . "INNER JOIN anneeacademique a ON a.ANNEEACADEMIQUE = t.PERIODE AND a.ANNEEACADEMIQUE = :anneeacad "
                . "WHERE i.IDCLASSE = :idclasse";
        return $this->query($query, ["idclasse" => $idclasse, "anneeacad" => $anneecad]);
    }

    public function getAbsenceAnnuelleByEleve($idclasse, $anneecad, $ideleve) {
        $query = "SELECT i.*, ap.*, s.ORDRE AS ORDRESEQUENCE "
                . "FROM inscription i "
                . "INNER JOIN absences_periodiques ap ON ap.ELEVE = i.IDELEVE "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = ap.SEQUENCE "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE "
                . "INNER JOIN anneeacademique a ON a.ANNEEACADEMIQUE = t.PERIODE AND a.ANNEEACADEMIQUE = :anneeacad "
                . "WHERE i.IDCLASSE = :idclasse AND i.IDELEVE = :ideleve";
        return $this->query($query, ["idclasse" => $idclasse, "anneeacad" => $anneecad, "ideleve" => $ideleve]);
    }

}
