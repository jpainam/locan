<?php

class trimestreModel extends Model {

    protected $_table = "trimestres";
    protected $_key = "IDTRIMESTRE";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "LIBELLE";
    }

    /**
     * Renvoi la liste des sequence inferieur a cette sequence
     * @param type $idtrimestre
     */
    public function getPreviousTrimestres($idtrimestre) {
        $query = "SELECT t.* "
                . "FROM trimestres t "
                . "WHERE t.ORDRE < (SELECT ORDRE FROM trimestres WHERE IDTRIMESTRE = :idtrim) "
                . "ORDER BY t.ORDRE ASC";
        return $this->query($query, ["idtrim" => $idtrimestre]);
    }

}
