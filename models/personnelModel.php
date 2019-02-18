<?php

class personnelModel extends Model {

    protected $_table = "personnels";
    protected $_key = "IDPERSONNEL";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT p.*, CONCAT(p.NOM,' ', p.PRENOM) AS CNOM, f.LIBELLE as LIBELLE FROM personnels p "
                . "LEFT JOIN fonctions f ON f.IDFONCTION = p.FONCTION "
                . "ORDER BY p.NOM";
        return $this->query($query);
    }

    /* public function insert($params = array()){
      $query = "INSERT INTO personnels(IDPERSONNEL, CIVILITE, NOM, PRENOM, AUTRENOM, FONCTION, "
      . "GRADE, DATENAISS, PORTABLE, TELEPHONE) "
      . "VALUE(:id, :civilite, :nom, :prenom, :autrenom, :fonction, :grade, :datenaiss, :portable, :telephone)";

      return $this->query($query, $params);
      } */

    public function getLibelle() {
        return "CNOM";
    }

    public function findBy($condition = array()) {
        $str = "";
        $params = array();
        foreach ($condition as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT p.*, arr.*, stru.*, di.*, cat.*, "
                . "reg.*, dept.*, f.LIBELLE AS LIBELLE "
                . "FROM `" . $this->_table . "` p "
                . "LEFT JOIN arrondissements arr ON arr.IDARRONDISSEMENT = p.ARRONDISSEMENT "
                . "LEFT JOIN departements dept ON arr.DEPARTEMENT = dept.IDDEPARTEMENT "
                . "LEFT JOIN regions reg ON reg.IDREGION = dept.REGION "
                . "LEFT JOIN etablissements stru ON stru.IDETABLISSEMENT = p.STRUCTURE "
                . "LEFT JOIN diplomes di ON di.IDDIPLOME = p.DIPLOME "
                . "LEFT JOIN categories cat ON cat.IDCATEGORIE = p.CATEGORIE "
                . "LEFT JOIN fonctions f ON p.FONCTION = f.IDFONCTION "
                . "WHERE $str ";
        return $this->query($query, $params);
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT p.*, CONCAT(p.NOM,' ', p.PRENOM) AS CNOM, f.LIBELLE AS FK_FONCTION,  "
                . "ar.*, ar.LIBELLE AS FK_ARRONDISSEMENT, "
                . "dept.*, dept.LIBELLE AS FK_DEPARTEMENT, "
                . "reg.*, reg.LIBELLE AS FK_REGION, "
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
                . "WHERE $str"
                . "ORDER BY p.NOM";
        return $this->row($query, $params);
    }

    /**
     * Obetenir la liste des enseignements de ce personnel
     * Utilise dans enseignant/index onglet 2
     * Si anneeacad est non vide, alors renvoye tous ses enseignement aucours de toutes les annees
     * @param type $idpersonnel
     */
    public function getEnseignements($idpersonnel, $anneeacad = "") {
        if (!empty($anneeacad)) {
            $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, p.*, c.*, c.LIBELLE AS CLASSELIBELLE, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                    . "WHERE e.PROFESSEUR = :idpersonnel";
            return $this->query($query, ["idpersonnel" => $idpersonnel, "anneeacad" => $anneeacad]);
        } else {
            $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, p.*, c.*, c.LIBELLE AS CLASSELIBELLE, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                    . "WHERE e.PROFESSEUR = :idpersonnel";
            return $this->query($query, ["idpersonnel" => $idpersonnel]);
        }
    }

}
