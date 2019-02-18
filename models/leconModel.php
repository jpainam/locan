<?php

class leconModel extends Model {

    protected $_table = "lecons";
    protected $_key = "IDLECON";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "TITRE";
    }

    /**
     * Obtenir les lecons connaissant l'activite
     * @param type $idactivite
     */
    public function getLeconsByActivite($idactivite) {
        $query = "SELECT l.*, l.TITRE AS TITRELECON, ch.*, ch.TITRE AS TITRECHAPITRE "
                . "FROM `" . $this->_table . "` l "
                . "INNER JOIN chapitres ch ON ch.IDCHAPITRE = l.CHAPITRE AND ch.ACTIVITE = :idactivite "
                . "ORDER BY ch.TITRE, l.TITRE";

        return $this->query($query, ["idactivite" => $idactivite]);
    }

    public function getLeconsByEnseignement($idenseignement) {
        $query = "SELECT l.*, l.TITRE AS TITRELECON, ch.*, "
                . "ch.TITRE AS TITRECHAPITRE, act.*, act.TITRE AS TITREACTIVITE "
                . "FROM `" . $this->_table . "` l "
                . "INNER JOIN chapitres ch ON ch.IDCHAPITRE = l.CHAPITRE "
                . "INNER JOIN activites act ON act.IDACTIVITE = ch.ACTIVITE AND act.ENSEIGNEMENT = :enseignement "
                . "ORDER BY ch.TITRE, l.TITRE";

        return $this->query($query, ["enseignement" => $idenseignement]);
    }

}
