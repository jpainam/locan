<?php

class moratoireModel extends Model {

    protected $_table = "moratoires";
    protected $_key = "IDMORATOIRE";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT mo.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG "
                . "FROM moratoires mo "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = mo.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = mo.ENREGISTRERPAR "
                . "WHERE mo.PERIODE = :anneeacad AND (mo.SUPPRIMER IS NULL or mo.SUPPRIMERPAR IS NULL) "
                . "ORDER BY mo.DATEOPERATION DESC";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);


        $query = "SELECT mo.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.*, resp.NOM AS NOMREP, "
                . "resp.PRENOM AS PRENOMREP, resp.PORTABLE AS PORTABLEREP, resp.NUMSMS AS "
                . "NUMSMS, resp.CIVILITE AS CIVILITEREP "
                . "FROM `" . $this->_table . "` mo "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = mo.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN responsable_eleve res_el ON res_el.IDELEVE = el.IDELEVE "
                . "LEFT JOIN responsables resp ON resp.IDRESPONSABLE = res_el.IDRESPONSABLE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = mo.ENREGISTRERPAR "
                . "WHERE $str AND mo.PERIODE = :_anneecad "
                . "ORDER BY mo.DATEOPERATION DESC";

        $params['_anneecad'] = $_SESSION['anneeacademique'];
        return $this->row($query, $params);
    }

}
