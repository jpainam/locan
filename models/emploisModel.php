<?php

class emploisModel extends Model{
    protected $_table = "emplois";
    protected  $_key = "IDEMPLOIS";
    
    public function __construct() {
        parent::__construct();
    }
    /**
     * Renvoi les information concernant 
     * l'emploi du temps de cette classe
     * @param type $idclasse
     */
    public function getEmplois($idclasse){
        $query = "SELECT e.*, m.*, p.*, h.* "
                . "FROM emplois e "
                . "INNER JOIN enseignements ee ON ee.CLASSE = :idclasse AND ee.IDENSEIGNEMENT = e.ENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = ee.MATIERE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = ee.PROFESSEUR "
                . "INNER JOIN horaires h ON h.IDHORAIRE = e.HORAIRE "
                . "ORDER BY e.ENSEIGNEMENT, h.ORDRE ASC";
        return $this->query($query, ["idclasse" => $idclasse]);
    }
    /**
     * Renvoi les information concernant 
     * l'emploi du temps de cette classe
     * @param type $idclasse
     */
    public function getEmploisByEnseignant($idenseignant){
        $query = "SELECT e.*, m.*, p.*, h.*, niv.* "
                . "FROM emplois e "
                . "INNER JOIN enseignements ee ON ee.IDENSEIGNEMENT = e.ENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = ee.MATIERE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = ee.CLASSE "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = ee.PROFESSEUR "
                . "INNER JOIN horaires h ON h.IDHORAIRE = e.HORAIRE "
                . "WHERE ee.PROFESSEUR = :prof "
                . "ORDER BY e.ENSEIGNEMENT, h.ORDRE ASC";
        return $this->query($query, ["prof" => $idenseignant]);
    }
    /**
     * Recherche les enseignements prevu par l'emploi du temps pour ce jour
     * et le classe donnees
     * @param type $jour
     * @param type $classe
     */
    public function getEnseignements($jour, $classe){
        $query = "SELECT e.*, m.* "
                . "FROM emplois e "
                . "INNER JOIN enseignements ee ON ee.CLASSE = :classe AND ee.IDENSEIGNEMENT = e.ENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = ee.MATIERE "
                . "WHERE e.JOUR = :jour"
                . "ORDER BY e.JOUR ASC";
        return $this->query($query, ["jour" => $jour, "classe" => $classe]);
    }
        /**
     * Retrouver la classe dans laquelle le professeur intervient 
     * connaissant l'horaire et le jour
     * @param type $idprofesseur
     * @param type $horaire
     * @param type $jour ( 1 = Lundi ... 7 = Dimanche)
     */
    public function getClasse($idprofesseur, $horaire, $jour){
        $query = "SELECT c.*, n.* "
                . "FROM classes c "
                . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "WHERE c.IDCLASSE = ("
                    . "SELECT ens.CLASSE "
                    . "FROM enseignements ens "
                    . "INNER JOIN emplois emp ON emp.ENSEIGNEMENT = ens.IDENSEIGNEMENT "
                    . "AND emp.JOUR = :jour AND emp.HORAIRE = :horaire "
                    . "WHERE ens.PROFESSEUR = :professeur"
                . ")";
        
        return $this->row($query, ["professeur" => $idprofesseur, 
            "horaire" => $horaire, "jour" => $jour]);
    }


}
