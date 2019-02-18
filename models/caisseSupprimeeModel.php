<?php

class caisseSupprimeeModel extends Model {

    protected $_table = "caisses_supprimees";
    protected $_key = "IDCAISSE";

    public function selectAll() {
        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU "
                . "FROM `". $this->_table."` ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE ca.PERIODE = :anneeacad "
                . "ORDER BY ca.DATETRANSACTION DESC";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

}
