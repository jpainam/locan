<?php

class chapitreModel extends Model {

    protected $_table = "chapitres";
    protected $_key = "IDCHAPITRE";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "TITRE";
    }

    /**
     * Obtenir les chapitre connaissant l'enseignement
     * @param type $enseignement
     */
    public function getChapitresByEnseignement($enseignement) {
        $query = "SELECT ch.*, ch.TITRE AS TITRECHAPITRE, act.*, act.TITRE AS TITREACTIVITE, "
                . "s.*, s.LIBELLE AS TITRESEQUENCE "
                . "FROM `" . $this->_table . "` ch "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = ch.SEQUENCE "
                . "INNER JOIN activites act ON act.IDACTIVITE = ch.ACTIVITE AND act.ENSEIGNEMENT = :enseignement "
                . "ORDER BY act.TITRE, ch.TITRE";

        return $this->query($query, ["enseignement" => $enseignement]);
    }

}
