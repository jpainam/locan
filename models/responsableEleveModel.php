<?php
class responsableEleveModel extends Model{
    protected  $_table = "responsable_eleve";
    protected  $_key = "IDRESPONSABLEELEVE";
    
    public function __construct() {
        parent::__construct();
    }
    public  function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        
        $query = "SELECT re.*, r.*, p.* "
                . "FROM `" . $this->_table . "` re "
                . "LEFT JOIN responsables r ON r.IDRESPONSABLE = re.IDRESPONSABLE "
                . "LEFT JOIN parente p ON p.LIBELLE = re.PARENTE "
                . "WHERE $str";
        return $this->row($query, $params);
    }
    /**
     * Renvoi la liste des parent d'eleve dont le numero n'est pas vide
     * et renvoi un seul si les deux parents possede des numsms
     * @param type $idclasse
     */
    public function getDistinctResponsableByClasse($idclasse){
        $query = "SELECT DISTINCT(re.IDELEVE), re.*, r.*, p.* "
                . "FROM `" . $this->_table . "` re "
                . "INNER JOIN responsables r ON r.IDRESPONSABLE = re.IDRESPONSABLE "
                . "LEFT JOIN parente p ON p.LIBELLE = re.PARENTE "
                . "WHERE r.NUMSMS <> '' AND re.IDELEVE IN ("
                . "SELECT IDELEVE FROM inscription WHERE IDCLASSE = :idclasse AND ANNEEACADEMIQUE = :anneeacad"
                . ")";
        return $this->query($query, ["idclasse" => $idclasse, "anneeacad" => $_SESSION['anneeacademique']]);
    }
    /**
     * Renvoi la liste des parent d'eleve dont le numero n'est pas vide
     * et renvoi un seul si les deux parents possede des numsms
     * @param type $idclasse
     */
    public function getDistinctResponsable(){
        $query = "SELECT DISTINCT(r.IDELEVE), re.*, r.*, p.* "
                . "FROM `" . $this->_table . "` re "
                . "INNER JOIN responsables r ON r.IDRESPONSABLE = re.IDRESPONSABLE "
                . "LEFT JOIN parente p ON p.LIBELLE = re.PARENTE "
                . "WHERE r.NUMSMS <> '' AND r.IDELEVE IN ("
                . "SELECT IDELEVE FROM inscription WHERE ANNEEACADEMIQUE = :anneeacad"
                . ")";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }
    public function getResponsablesForCurrentStudent($anneeacad){
        $query = "SELECT re.*, r.* "
                . "FROM `" . $this->_table . "` re "
                . "INNER JOIN responsables r ON r.IDRESPONSABLE = re.IDRESPONSABLE "
                . "INNER JOIN eleves el ON el.IDELEVE = re.IDELEVE "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacad";
        return $this->query($query, array("anneeacad" => $anneeacad));
    }
}
