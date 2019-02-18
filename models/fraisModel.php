<?php

class fraisModel extends Model {

    protected $_table = "frais";
    protected $_key = "IDFRAIS";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtenir les frais scolaire pour cette annee academique
     * @param varchar $anneeacad l'annee academique en cours
     */
    public function getFrais($anneeacad) {
        $query = "SELECT f.*, c.*, n.* "
                . "FROM frais f "
                . "LEFT JOIN classes c ON c.IDCLASSE = f.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad 
				INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU ";
        return $this->query($query, ["anneeacad" => $anneeacad]);
    }

    /**
     * Obtenir la liste des frais de l'eleve pour cette annee academique
     * @param type $eleve
     * @param type $anneeacad
     */
    public function getEleveFrais($eleve, $anneeacad) {
        $query = "SELECT f.* "
                . "FROM frais f "
                . "INNER JOIN inscription i "
                . "ON i.IDELEVE = :ideleve AND i.IDCLASSE = f.CLASSE AND i.ANNEEACADEMIQUE = :anneeacad "
                . "ORDER BY f.ECHEANCES";
        return $this->query($query, ["ideleve" => $eleve, "anneeacad" => $anneeacad]);
    }

    /**
     * Obtenir la liste des frais pour cette classe
     * @param type $idclasse
     */
    public function getClasseFrais($idclasse) {
        $query = "SELECT f.*, c.* "
                . "FROM frais f "
                . "LEFT JOIN classes c ON c.IDCLASSE = f.CLASSE "
                . "WHERE f.CLASSE = :idclasse "
                . "ORDER BY f.ECHEANCES";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

    /**
     * Obtenir le montant total des frais a payes pour cette classe
     * @param type $idclasse
     */
    public function getClasseTotalFrais($idclasse) {
        $query = "SELECT SUM(MONTANT) AS TOTALFRAIS "
                . "FROM `" . $this->_table . "` f "
                . "WHERE f.CLASSE = :idclasse";
        return $this->row($query, ["idclasse" => $idclasse]);
    }

    public function getClasseSommeFrais() {
        $query = "SELECT f.CLASSE, SUM(MONTANT) AS TOTALFRAIS "
                . "FROM `" . $this->_table . "` f "
                . "INNER JOIN classes cl ON cl.IDCLASSE = f.CLASSE AND cl.ANNEEACADEMIQUE = :anneeacad "
                . "GROUP BY f.CLASSE";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

    /**
     * Obtenir le montant total des frais applicable en se basant sur la date du systeme
     * @param type $idclasse
     */
    public function getTotalFraisApplicables($idclasse) {
        $query = "SELECT SUM(MONTANT) AS MONTANTAPPLICABLE "
                . "FROM `" . $this->_table . "` f "
                . " WHERE ECHEANCES <= CURDATE() AND f.CLASSE = :idclasse";

        return $this->row($query, ["idclasse" => $idclasse]);
    }

    /**
     * Function utiliser dans etablissement, liste debitaire des eleve de 
     * tout l etablissement
     * @return type
     */
    public function getAllFraisApplicables() {
        $query = "SELECT f.CLASSE, SUM(MONTANT) AS MONTANTAPPLICABLE "
                . "FROM `" . $this->_table . "` f "
                . "INNER JOIN classes cl ON cl.ANNEEACADEMIQUE = :anneeacad AND f.CLASSE = cl.IDCLASSE "
                . "WHERE ECHEANCES <= CURDATE() "
                . "GROUP BY f.CLASSE";

        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

    /**
     * Obtenir le dernier frais encours d'application
     * utiliser dans l'impression des lettre de rappel dans classe/index
     * @param type $idclasse
     */
    public function getLastFrais($idclasse) {
        $query = "SELECT * FROM frais "
                . "WHERE CLASSE = :idclasse AND ECHEANCES <= CURDATE() "
                . "ORDER BY ECHEANCES DESC, DESCRIPTION  DESC "
                . "LIMIT 1";
        return $this->row($query, ["idclasse" => $idclasse]);
    }

}
