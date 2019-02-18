<?php

class etablissementModel extends Model{
    protected  $_table = "etablissements";
    protected $_key = "IDETABLISSEMENT";


    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "ETABLISSEMENT";
    }
    public function selectAll() {
        $query = "SELECT * FROM `" . $this->_table . "` ORDER BY ETABLISSEMENT";
        return $this->query($query);
    }
    /**
     * Tous les enseignants de cet etablissement pour cette annee academique
     * @param type $anneeacad
     * @return type
     */
    public function getEnseignants($anneeacad){
        $query = "SELECT p.*, f.LIBELLE AS FK_FONCTION, "
                . "ar.LIBELLE AS FK_ARRONDISSEMENT, "
                . "dept.LIBELLE AS FK_DEPARTEMENT, "
                . "reg.LIBELLE AS FK_REGION, "
                . "stru.ETABLISSEMENT AS FK_STRUCTURE, "
                . "cat.LIBELLE AS FK_CATEGORIE, "
                . "di.LIBELLE AS FK_DIPLOME, "
                . "st.LIBELLE AS FK_STATUT "
                . "FROM personnels p "
                . "LEFT JOIN fonctions f ON f.IDFONCTION = p.FONCTION "
                . "LEFT JOIN arrondissements ar ON ar.IDARRONDISSEMENT = p.ARRONDISSEMENT "
                . "LEFT JOIN departements dept ON dept.IDDEPARTEMENT = ar.DEPARTEMENT "
                . "LEFT JOIN regions reg ON reg.IDREGION = dept.REGION "
                . "LEFT JOIN etablissements stru ON stru.IDETABLISSEMENT = p.STRUCTURE "
                . "LEFT JOIN categories cat ON cat.IDCATEGORIE = p.CATEGORIE "
                . "LEFT JOIN diplomes di ON di.IDDIPLOME = p.DIPLOME "
                . "LEFT JOIN statut_personnels st ON st.IDSTATUTPERSONNEL = p.STATUT "
                . "WHERE p.IDPERSONNEL IN ("
                    . "SELECT ens.PROFESSEUR "
                    . "FROM enseignements ens "
                    . "INNER JOIN classes c ON c.IDCLASSE = ens.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad"
                . ") "
                . "ORDER BY p.NOM";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }
     public function getNouveauEleves(){
         $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, "
                 . "IF(e.REDOUBLANT=0, 'NON', 'OUI') AS REDOUBLANTLBL, "
                . "p.ETABLISSEMENT AS FK_PROVENANCE, m.LIBELLE AS FK_MOTIFSORTIE, p2.PAYS AS FK_NATIONALITE, "
                . "p3.PAYS AS FK_PAYSNAISS, "
                . "c.*, c.LIBELLE AS CLASSECOURANTE, "
                . "n.* "
                . "FROM eleves e "
                . "LEFT JOIN etablissements p ON p.IDETABLISSEMENT = e.PROVENANCE "
                . "LEFT JOIN motifsortie m ON m.IDMOTIF = e.MOTIFSORTIE "
                . "LEFT JOIN pays p2 ON p2.IDPAYS = e.NATIONALITE "
                . "LEFT JOIN pays p3 ON p3.IDPAYS = e.PAYSNAISS "
                . "INNER JOIN classes c ON c.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                 . "WHERE NOT EXISTS (SELECT * FROM inscription ins WHERE ins.IDELEVE = e.IDELEVE AND ins.ANNEEACADEMIQUE < :anneeacad1) "
                . "ORDER BY TRIM(e.NOM)";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], 
            "anneeacad1" => $_SESSION['anneeacademique']]);
}
}