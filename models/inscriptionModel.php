<?php

class inscriptionModel extends Model {

    protected $_table = "inscription";
    protected $_key = "IDINSCRIPTION";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Liste des eleves deja inscrits pour cette classe
     * @param type $idclasse
     * @param type $anneeacademique
     * @return type la liste des eleves inscripts
     */

    /**
     * $query = "SELECT e.*, CONCAT(e.MATRICULE, ' - ', e.NOM, ' ', e.PRENOM) AS CNOM, "
      . "p.ETABLISSEMENT AS FK_PROVENANCE, m.LIBELLE AS FK_MOTIFSORTIE, p2.PAYS AS FK_NATIONALITE, "
      . "p3.PAYS AS FK_PAYSNAISS, "
      . "c.*, c.LIBELLE AS CLASSECOURANTE, "
      . "n.* "
      . "FROM eleves e "
      . "LEFT JOIN etablissements p ON p.IDETABLISSEMENT = e.PROVENANCE "
      . "LEFT JOIN motifsortie m ON m.IDMOTIF = e.MOTIFSORTIE "
      . "LEFT JOIN pays p2 ON p2.IDPAYS = e.NATIONALITE "
      . "LEFT JOIN pays p3 ON p3.IDPAYS = e.PAYSNAISS "
      . "LEFT JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.ANNEEACADEMIQUE = :anneeacademique "
      . "LEFT JOIN  classes c "
      . "ON c.IDCLASSE = i.IDCLASSE AND i.IDELEVE = e.IDELEVE AND c.ANNEEACADEMIQUE = :anneeacad "
      . "AND c.ANNEEACADEMIQUE = i.ANNEEACADEMIQUE "
      . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
      . "ORDER BY e.MATRICULE";
     */
    public function getInscrits($idclasse, $anneeacademique = "") {

        if (empty($anneeacademique)) {
            $anneeacademique = $_SESSION['anneeacademique'];
        }
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION, "
                . "p.ETABLISSEMENT AS FK_PROVENANCE, m.LIBELLE AS FK_MOTIFSORTIE, p2.PAYS AS FK_NATIONALITE, "
                . "p3.PAYS AS FK_PAYSNAISS, "
                . "c.*, c.LIBELLE AS CLASSECOURANTE, "
                . "n.* "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND "
                . "i.IDCLASSE = :idclasse AND i.ANNEEACADEMIQUE = :anneeacademique "
                . "LEFT JOIN etablissements p ON p.IDETABLISSEMENT = e.PROVENANCE "
                . "LEFT JOIN motifsortie m ON m.IDMOTIF = e.MOTIFSORTIE "
                . "LEFT JOIN pays p2 ON p2.IDPAYS = e.NATIONALITE "
                . "LEFT JOIN pays p3 ON p3.IDPAYS = e.PAYSNAISS "
                . "LEFT JOIN classes c ON c.IDCLASSE = i.IDCLASSE "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "ORDER BY TRIM(e.NOM)";
        $eleves = $this->query($query, ["idclasse" => $idclasse, "anneeacademique" => $anneeacademique]);
        return $eleves;
    }

    /**
     * Liste des eleves succeptible d'etre inscrit,
     * cette liste est egale a liste totale moins ceux qui sont deja inscrit dans n'importe qu'elle classe
     * @param type $anneeacademique
     *  * @return type la liste des eleves non inscript durant cette annee academique
     */
    public function getNonInscrits($anneeacademique) {
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM FROM eleves e "
                . "WHERE e.IDELEVE NOT IN (SELECT i.IDELEVE FROM inscription i "
                . "WHERE i.ANNEEACADEMIQUE = :anneeacademique) "
                . "ORDER BY TRIM(e.NOM)";
        $eleves = $this->query($query, ["anneeacademique" => $anneeacademique]);
        return $eleves;
    }

    /**
     * Renvoi pour une annnee academique, la liste des eleves inscrite durant cette
     * annee academique
     * @param type $anneeacad
     * @return type
     */
    public function getAllInscrits($anneeacad) {
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND "
                . " i.ANNEEACADEMIQUE = :anneeacademique "
                . "ORDER BY TRIM(e.NOM)";
        return $this->query($query, ["anneeacademique" => $anneeacad]);
    }

    /**
     * Obtenir toutes les infos concernant tous les inscriptions de cet eleve
     * Utiliser dans eleve/index pour l'onglet5 : Les notes de toutes les classes de cette eleve
     * @param type $ideleve
     */
    public function getAllInscriptions($ideleve) {
        $query = "SELECT i.*, e.*, c.*, n.*, a.* "
                . "FROM inscription i "
                . "INNER JOIN eleves e ON e.IDELEVE = i.IDELEVE "
                . "INNER JOIN classes c ON c.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "INNER JOIN anneeacademique a ON a.ANNEEACADEMIQUE = i.ANNEEACADEMIQUE "
                . "WHERE i.IDELEVE = :ideleve "
                . "ORDER BY n.GROUPE, a.ANNEEACADEMIQUE";

        return $this->query($query, ["ideleve" => $ideleve]);
    }

    public function getInscritParClasse() {
        $query = "SELECT cl.*, COUNT(insc.IDELEVE) AS NBINSCRITS "
                . "FROM inscription insc "
                . "INNER JOIN classes cl ON cl.IDCLASSE = insc.IDCLASSE "
                . "GROUP BY insc.IDCLASSE";
        return $this->query($query);
    }

}
