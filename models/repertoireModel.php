<?php

class repertoireModel extends Model {
    public function __construct() {
        parent::__construct();
    }
    
    /** Obtenir tous les numero de telephone des personnels
     * et des parents de l'etablissement
     */
    public function selectAll(){
        $query = "SELECT '' AS CIVILITE, CONCAT(ID,'-',NOM) AS NOM , CONCAT(TELEPHONE, '/', TELEPHONE2) AS TELEPHONE,"
                . " MOBILE AS PORTABLE, EMAIL FROM locan "
                . "UNION "
                . "SELECT CIVILITE, CONCAT(NOM,' ', PRENOM) AS NOM, TELEPHONE, PORTABLE, EMAIL FROM personnels "
                . "UNION "
                . "SELECT CIVILITE, CONCAT(NOM, ' ', PRENOM) AS NOM, TELEPHONE, PORTABLE, EMAIL FROM responsables ";
        return $this->query($query);
    }
    
    /**
     * Fonction utilisee pour remplir la liste des destinataire lors de la saisie d'un SMS
     */
    public function getDestinataires(){
        $query = "SELECT '' AS CIVILITE, CONCAT(ID, '-', NOM) AS NOM, MOBILE AS PORTABLE "
                . "FROM locan "
                . "UNION "
                . "SELECT CIVILITE, CONCAT(NOM, ' ', PRENOM) AS NOM, PORTABLE FROM personnels "
                . "UNION "
                . "SELECT CIVILITE, CONCAT(NOM, ' ', PRENOM) AS NOM, PORTABLE FROM responsables ";
        return $this->query($query);
    }
}
