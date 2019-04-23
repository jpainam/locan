<?php

class sequenceModel extends Model {

    protected $_table = "sequences";
    protected $_key = "IDSEQUENCE";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "LIBELLE";
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT s.* FROM `" . $this->_table . "` s WHERE $str "
                . "ORDER BY s.ORDRE ASC";

        return $this->query($query, $params);
    }

    /**
     * Retourne la liste des sequences pour cette anneee academique
     * @param type $anneeacad
     */
    public function getSequences($anneeacad) {
        $query = "SELECT s.* "
                . "FROM sequences s "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE AND t.PERIODE = :anneeacad";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }

    public function getSequenceByDate($datejour) {
        $query = "SELECT seq.*, tr.*, ann.*, seq.ORDRE AS SEQUENCEORDRE, tr.ORDRE AS TRIMESTREORDRE "
                . "FROM `" . $this->_table . "` seq "
                . "INNER JOIN trimestres tr ON tr.IDTRIMESTRE = seq.TRIMESTRE "
                . "INNER JOIN anneeacademique ann ON ann.ANNEEACADEMIQUE = tr.PERIODE "
                . "WHERE :datejour BETWEEN seq.DATEDEBUT AND seq.DATEFIN";
        return $this->row($query, ["datejour" => $datejour]);
    }

    public function getSequencesVerrouilles($anneeacad) {
        $query = "SELECT s.* "
                . "FROM sequences s "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE AND t.PERIODE = :anneeacad "
                . "WHERE s.VERROUILLER = 1";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "s.DATEDEBUT AS DEBUTSEQUENCE, s.DATEFIN AS FINSEQUENCE, "
                . "s.ORDRE AS SEQUENCEORDRE, t.*, t.ORDRE AS TRIMESTREORDRE, "
                . "ann.*, ann.DATEFIN AS FINANNEE, ann.DATEDEBUT AS DEBUTANNEE "
                . "FROM sequences s "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE "
                . "INNER JOIN anneeacademique ann ON ann.ANNEEACADEMIQUE = t.PERIODE "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    public function getSequenceBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT s.* "
                . "FROM sequences s "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    /**
     * Renvoi la liste des sequence inferieur a cette sequence
     * @param type $idsequence
     */
    public function getPreviousSequences($idsequence) {
        $query = "SELECT s.* "
                . "FROM sequences s "
                . "WHERE s.ORDRE < (SELECT ORDRE FROM sequences WHERE IDSEQUENCE = :idseq) "
                . "ORDER BY s.ORDRE ASC";
        return $this->query($query, ["idseq" => $idsequence]);
    }
    
    public function getIdSequences($anneeacad){
        $query = "SELECT IDSEQUENCE 
                FROM sequences s 
                INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE 
                INNER JOIN anneeacademique a ON a.ANNEEACADEMIQUE = t.PERIODE 
                WHERE t.PERIODE = :anneeacad";
        return $this->column($query, ["anneeacad" => $anneeacad]);
    }

}
