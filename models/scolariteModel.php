<?php

class scolariteModel extends Model {

    protected $_table = "scolarites";
    protected $_key = "IDSCOLARITE";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir les scolarites payes de cet eleve
     * @param type $anneeacad
     */
    public function getScolarites($eleve, $anneeacad) {
        $query = "SELECT s.*,s.MONTANT AS MONTANTPAYE, f.*, f.MONTANT as MONTANTFRAIS "
                . "FROM scolarites s "
                . "LEFT JOIN frais f ON f.IDFRAIS = s.FRAIS "
                . "WHERE s.ELEVE = :eleve AND s.ANNEEACADEMIQUE = :anneeacad "
                . "ORDER BY s.DATEPAYEMENT";
        return $this->query($query, ["eleve" => $eleve, "anneeacad" => $anneeacad]);
    }

    /**
     * Pour une operation caisse donnees, il retourne m
     * la somme des payement scolaire se basant sur cette operation caisse
     * @param type $idcaisse
     */
    public function getTotalByCaisse($idcaisse) {
        $query = "SELECT SUM(s.MONTANT) AS TOTAL "
                . "FROM scolarites s "
                . "WHERE s.CAISSE = :caisse";
        return $this->row($query, ["caisse" => $idcaisse]);
    }
    /**
     * Obtenir les eleves ayant paye ce frais, 
     * un frais appartienne a une seule classe, du coup, pas besoin de la classe
     * @param type $idfrais
     * @return type
     */
    public function getScolariteEleveByFrais($idfrais) {
        $query = "SELECT e.*, f.*, s.*, "
                . "p.NOM AS NOMREALISATEUR, p.PRENOM AS PRENOMREALISATEUR "
                . "FROM eleves e "
                . "LEFT JOIN frais f ON f.IDFRAIS = :idfrais "
                . "LEFT JOIN scolarites s ON s.FRAIS = f.IDFRAIS AND s.ELEVE = e.IDELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = s.REALISERPAR "
                . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = f.CLASSE "
                . "ORDER BY e.NOM";
        return $this->query($query, ["idfrais" => $idfrais]);
    }
    
    /**
     * $array_of_id_frais [1, 2, 3, ...]
     * @param array $array_of_id_frais tableau de frais
     * @param type $idclasse
     */
    public function getElevesForAllFrais($array_of_id_frais, $idclasse){
        $frais = implode(",", $array_of_id_frais);
        
        $query = "SELECT el.* FROM eleves el "
                . "INNER JOIN "
                . "(SELECT e.IDELEVE "
                    . "FROM eleves e "
                    . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = :idclasse "
                    . "WHERE e.IDELEVE NOT IN (SELECT e2.IDELEVE FROM eleves e2 "
                                        . "INNER JOIN scolarites s ON s.ELEVE = e2.IDELEVE AND s.FRAIS IN (:frais) "
                                        . "INNER JOIN inscription i2 ON i2.IDELEVE = e2.IDELEVE AND i2.IDCLASSE = :idclasse2)"
                . ") insolv ON el.IDELEVE = insolv.IDELEVE "
                . "ORDER BY el.NOM";
        return $this->query($query, ["frais" => $frais, "idclasse" => $idclasse, "idclasse2" => $idclasse]);
    }
    
}
