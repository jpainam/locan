<?php

# Code droit 531 autorisant l'utilisater a gerer meme les classes ou il n'intervienn pas

class enseignementModel extends Model {

    protected $_table = "enseignements";
    protected $_key = "IDENSEIGNEMENT";

    public function __construct() {
        parent::__construct();
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);

        $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, "
                . "p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.*, n.* "
                . "FROM `" . $this->_table . "` e "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);

        $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, "
                . "p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.*, n.* "
                . "FROM `" . $this->_table . "` e "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN niveau n ON c.NIVEAU = n.IDNIVEAU "
                . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                . "WHERE $str";

        return $this->query($query, $params);
    }

    /**
     * le idgroupe a ete utiliser dans l'impression des bulletin
     * voulant obtenir les matieres groupees par groupe
     * @param type $idclasse
     * @param type $idgroupe
     * @return type
     */
    public function getEnseignements($idclasse, $idgroupe = "") {
        if (empty($idgroupe)) {
            if (isAuth(531)) {
                $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                        . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                        . "FROM enseignements e "
                        . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                        . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                        . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                        . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                        . "WHERE e.CLASSE = :classe "
                        . "ORDER BY e.ORDRE, m.LIBELLE";

                $params = ["classe" => $idclasse];
            } else {
                $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                        . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                        . "FROM enseignements e "
                        . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                        . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                        . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                        . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                        . "WHERE e.CLASSE = :classe "
                        . "ORDER BY e.ORDRE, m.LIBELLE";

                $params = ["classe" => $idclasse, "restriction" => $_SESSION['iduser']];
            }
        } else {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                    . "FROM enseignements e "
                    . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "LEFT JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "WHERE e.CLASSE = :classe AND e.GROUPE = :groupe "
                    . "ORDER BY e.ORDRE, m.LIBELLE";

            $params = ["classe" => $idclasse, "groupe" => $idgroupe];
        }
        return $this->query($query, $params);
    }

    /**
     * Obtenir la liste des matieres non enseigner dans cette classe
     * @param type $idclasse
     */
    public function getNonEnseignements($idclasse) {
        $query = "SELECT m.* FROM matieres m "
                . "WHERE m.IDMATIERE NOT IN (SELECT e.MATIERE "
                . "FROM enseignements e WHERE e.CLASSE = :idclasse) "
                . "ORDER BY m.LIBELLE";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

    /**
     * Renvoie tous les enseignement qui passe dans cette annee academique
     * @param type $anneeacad
     */
    public function getAllEnseignements($anneeacad) {
        if (isAuth(531)) {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad 
				INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "ORDER BY e.ORDRE";

            $params = ["anneeacad" => $anneeacad];
            return $this->query($query, $params);
        } else {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION, n.* "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad 
				INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "ORDER BY e.ORDRE";

            $params = ["anneeacad" => $anneeacad, "restriction" => $_SESSION['iduser']];
            return $this->query($query, $params);
        }
    }

    /**
     * Obtenir la liste des personnels enseignants dans cette classe
     * @param type $idclasse
     */
    public function getPersonnelsEnseignants($idclasse) {
        $query = "SELECT p.* "
                . "FROM personnels p "
                . "WHERE p.IDPERSONNEL IN ("
                . "SELECT ens.PROFESSEUR FROM enseignements ens WHERE ens.CLASSE = :idclasse"
                . ") "
                . "ORDER BY p.NOM";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

    /**
     * Obtenir la liste des enseignement dans laquelle passe cette matiere
     * utiliser dans la couverture dans statistique controller
     * @param type $idmatiere
     */
    public function getClassesByMatiere($idmatiere) {
        $query = "SELECT ens.*, cl.LIBELLE AS CLASSELIBELLE, cl.*, n.*, mat.* "
                . "FROM enseignements ens "
                . "INNER JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = :matiere AND mat.IDMATIERE = ens.MATIERE "
                . "ORDER BY n.GROUPE ASC";
        return $this->query($query, ["matiere" => $idmatiere]);
    }

}
