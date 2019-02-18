<?php

# Droit attribue a ceux qui peuvent gerer toutes les classes 531

class classeModel extends Model {

    protected $_table = "classes";
    protected $_key = "IDCLASSE";

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

        $query = "SELECT c.*, n.*, pp.NOM AS NOMPROFPRINCIPAL, pp.PRENOM AS PRENOMPROFPRINCIPAL "
                . "FROM `" . $this->_table . "` c "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                . "LEFT JOIN classes_parametres cp ON cp.CLASSE = c.IDCLASSE AND cp.ANNEEACADEMIQUE = :anneeacad1234 "
                . "LEFT JOIN personnels pp ON pp.IDPERSONNEL = cp.PROFPRINCIPALE "
                . "WHERE $str";
        $params['anneeacad1234'] = $_SESSION['anneeacademique'];
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

        if (isAuth(531)) {
            $query = "SELECT c.*, n.*, cy.* "
                    . "FROM `" . $this->_table . "` c "
                    . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN cycles cy ON cy.IDCYCLE = c.CYCLE "
                    . "WHERE $str "
                    . "ORDER BY n.GROUPE DESC, n.NIVEAUHTML ASC";
            return $this->query($query, $params);
        } else {
            $query = "SELECT c.*, n.*, cy.* "
                    . "FROM `" . $this->_table . "` c "
                    . "INNER JOIN enseignements ens ON ens.CLASSE = c.IDCLASSE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = ens.PROFESSEUR AND p.USER = :restriction "
                    . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN cycles cy ON cy.IDCYCLE = c.CYCLE "
                    . "WHERE $str "
                    . "ORDER BY n.GROUPE DESC, n.NIVEAUHTML ASC";

            $params['restriction'] = $_SESSION['iduser'];

            return $this->query($query, $params);
        }
    }

    public function selectAll() {
        /* $query = "SELECT c.*, d.LIBELLE AS FK_DECOUPAGE FROM classes c "
          . "LEFT JOIN decoupage d ON c.DECOUPAGE = d.IDDECOUPAGE"; */
        if (isAuth(531)) {
            $query = "SELECT DISTINCT(c.IDCLASSE), c.* , d.LIBELLE AS FK_DECOUPAGE, n.*, cy.* "
                    . "FROM classes c "
                    . "LEFT JOIN decoupage d ON c.DECOUPAGE = d.IDDECOUPAGE "
                    . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN cycles cy ON cy.IDCYCLE = c.CYCLE "
                    . "WHERE c.ANNEEACADEMIQUE = :anneeacad "
                    . "ORDER BY n.GROUPE DESC, c.LIBELLE ASC, NIVEAUHTML ASC";
            return $this->query($query, ['anneeacad' => $_SESSION['anneeacademique']]);
        } else {
            $query = "SELECT DISTINCT(c.IDCLASSE), c.* , d.LIBELLE AS FK_DECOUPAGE, n.*, cy.* "
                    . "FROM classes c "
                    . "INNER JOIN enseignements ens ON ens.CLASSE = c.IDCLASSE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = ens.PROFESSEUR AND p.USER = :restriction "
                    . "LEFT JOIN decoupage d ON c.DECOUPAGE = d.IDDECOUPAGE "
                    . "LEFT JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN cycles cy ON cy.IDCYCLE = c.CYCLE "
                    . "WHERE c.ANNEEACADEMIQUE = :anneeacad "
                    . "ORDER BY n.GROUPE DESC, c.LIBELLE ASC, NIVEAUHTML ASC";

            $params = ["restriction" => $_SESSION['iduser'],
                'anneeacad' => $_SESSION['anneeacademique']];
            return $this->query($query, $params);
        }
    }

    /**
     * 
     * @param type $idclasse
     * @param type $matric
     * @return typeSELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION 
      FROM eleves e
      INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND
      i.IDCLASSE = 1
      WHERE e.MATRICULE LIKE '155%'
      ORDER BY e.MATRICULE DESC LIMIT 1
     */
    public function findLastEleve($idclasse, $matric) {
        $matric = $matric . "%";
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM, i.IDINSCRIPTION "
                . "FROM eleves e "
                . "INNER JOIN inscription i ON e.IDELEVE = i.IDELEVE AND "
                . "i.IDCLASSE = :idclasse "
                . "WHERE e.MATRICULE LIKE :matric "
                . "ORDER BY e.MATRICULE DESC LIMIT 1";

        $params = ["idclasse" => $idclasse, "matric" => $matric];
        return $this->row($query, $params);
    }

    public function findLastEleveFromGroupe($groupe, $matric) {
        $matric = $matric . "%";
        $query = "SELECT e.*, CONCAT(e.NOM, ' ', e.PRENOM) AS CNOM "
                . "FROM eleves e "
                . "WHERE e.IDELEVE IN "
                . "(SELECT i.IDELEVE "
                . "FROM inscription i "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU AND niv.GROUPE = :groupe "
                . "WHERE i.ANNEEACADEMIQUE = :anneeacad) "
                . "AND e.MATRICULE LIKE :matric "
                . "ORDER BY e.MATRICULE DESC LIMIT 1";

        $params = ["groupe" => $groupe, "matric" => $matric, "anneeacad" => $_SESSION['anneeacademique']];
        return $this->row($query, $params);
    }

    public function getLibelle() {
        return "LIBELLE";
    }

    /**
     * Obtenir les redoublant de n'importe quel classe pour cette annee academique
     * @param type $anneeacademique
     * @param type $ids_only si vrai, renvoye seulement les ID des eleve,
     * default false  renvoye les infos concernant l'eleve
     */
    public function getRedoublantsByAnneeAcademique($anneeacademique, $ids_only = false) {

        if ($ids_only === true) {
            $query = "SELECT e.IDELEVE "
                    . "FROM eleves e "
                    . "INNER JOIN classes c ON c.ANNEEACADEMIQUE = :anneeacad  "
                    . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE "
                    . "INNER JOIN niveau n ON n.IDNIVEAU = c.NIVEAU "
                    . "WHERE IF((SELECT COUNT(i3.ANNEEACADEMIQUE) AS NBRE FROM inscription i3 "
                    . "WHERE i3.IDELEVE = e.IDELEVE) > 1, "
                    . "(SELECT COUNT(i2.IDINSCRIPTION) FROM inscription i2 "
                    . "WHERE i2.IDELEVE = i.IDELEVE) > 1 "
                    . "AND c.IDCLASSE IN (SELECT c2.IDCLASSE FROM classes c2 "
                    . "INNER JOIN niveau n2 ON n2.IDNIVEAU = c2.NIVEAU "
                    . "WHERE n2.GROUPE = n.GROUPE), e.REDOUBLANT = 1)";
            return $this->column($query, ["anneeacad" => $anneeacademique]);
        } else {
            # Pas encore implemente
            return null;
        }
    }

    /**
     * Renvoi la liste des eleves redoublant une classe de meme niveau
     * @param string $idclasse si vide, alors renvoye la liste des eleve redoublant quelque soit la classe de meme niveau
     * @param string $anneeacademique
     * @params boolean $ids_only faut-il renvoyer seulements les id des 
     * @return array contenant les eleves redoublant
     *
     */
    public function getRedoublants($idclasse, $anneeacademique = "", $ids_only = false) {
        if ($ids_only === true) {
            $query = "SELECT i.IDELEVE, COUNT(i.IDELEVE) AS NBINSCRIPTION  
                    FROM inscription i 
                    INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE 
                    INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU 
                    WHERE niv.GROUPE = (SELECT niv.GROUPE FROM niveau niv 
                    INNER JOIN classes cl ON cl.IDCLASSE = :idclasse1 AND cl.NIVEAU = niv.IDNIVEAU)  
                    AND i.IDELEVE IN (SELECT IDELEVE FROM inscription i 
                                     WHERE i.IDCLASSE = :idclasse2) 
                    GROUP BY i.IDELEVE
                    HAVING (NBINSCRIPTION) > 1";

            $params = ["idclasse1" => $idclasse, "idclasse2" => $idclasse];

            if ($_SESSION['anneeacademique'] === FIRST_ACADEMIQUE_YEAR) {
            $query = "SELECT e.IDELEVE "
                    . "FROM eleves e "
                        . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = :idclasse "
                        . "AND i.ANNEEACADEMIQUE = :anneeacad "
                        . "WHERE  e.REDOUBLANT = 1";

                $params = ['idclasse' => $idclasse, "anneeacad" => $anneeacademique];
            }
            return $this->column($query, $params);
        } else {
            $query = "SELECT el.*, COUNT(i.IDELEVE) AS NBINSCRIPTION 
                    FROM inscription i 
                    INNER JOIN eleves el ON el.IDELEVE = i.IDELEVE 
                    INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE 
                    INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU 
                    WHERE niv.GROUPE = (SELECT niv.GROUPE FROM niveau niv 
                    INNER JOIN classes cl ON cl.IDCLASSE = :idclasse1 AND cl.NIVEAU = niv.IDNIVEAU)  
                    AND i.IDELEVE IN (SELECT IDELEVE FROM inscription i 
                                     WHERE i.IDCLASSE = :idclasse2) 
                    GROUP BY i.IDELEVE
                    HAVING (NBINSCRIPTION) > 1";
            $params = ["idclasse1" => $idclasse, "idclasse2" => $idclasse];
            
            if ($_SESSION['anneeacademique'] === FIRST_ACADEMIQUE_YEAR) {
            $query = "SELECT e.*, c.* "
                    . "FROM eleves e "
                        . "INNER JOIN classes c ON c.IDCLASSE = :idclasse "
                        . "INNER JOIN inscription i ON i.IDELEVE = e.IDELEVE AND i.IDCLASSE = c.IDCLASSE AND i.ANNEEACADEMIQUE = :anneeacad "
                        . "WHERE e.REDOUBLANT = 1";
                $params = ['idclasse' => $idclasse, "anneeacad" => $anneeacademique];
            }
            return $this->query($query, $params);
        }
    }

    /**
     * Obtenir pour chaque eleve de cette classe son solde
     * @param type $idclasse
     */
    public function getSoldeEleves($idclasse) {

        $query = "SELECT el.*, so.*, n.* "
                . "FROM "
                . "(SELECT IFNULL(SUM(ca.MONTANT),0) AS MONTANTPAYE, co.* FROM comptes_eleves co "
                . "LEFT JOIN caisses ca ON co.IDCOMPTE = ca.COMPTE AND ca.VALIDE = 1 AND ca.PERIODE = :anneeacad "
                . "GROUP BY co.IDCOMPTE) so, eleves el "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :idclasse "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "WHERE el.IDELEVE = so.ELEVE "
                . "ORDER BY el.NOM";

        return $this->query($query, ["idclasse" => $idclasse, "anneeacad" => $_SESSION['anneeacademique']]);
    }
    public function getSoldeEleves1($idclasse){
        $query = "SELECT el.*, co.*, IFNULL(SUM(ca.MONTANT), 0) AS MONTANTPAYE, n.* "
                . "FROM eleves el "
                . "LEFT JOIN comptes_eleves co ON co.ELEVE = el.IDELEVE "
                . "LEFT JOIN caisses ca ON ca.COMPTE = co.IDCOMPTE AND ca.PERIODE = :anneeacad "
                . "INNER JOIN classes cl ON cl.IDCLASSE = :idclasse "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = cl.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "GROUP BY el.IDELEVE "
                . "ORDER BY el.NOM";
        return $this->query($query, ["idclasse" => $idclasse, "anneeacad" => $_SESSION['anneeacademique']]);
    }

    /**
     * Situation financiere de tous les eleve de l etablissement
     */
    public function getSoldeAllEleves() {
        $query = "SELECT el.*, cl.*, so.*, n.* "
                . "FROM "
                . "(SELECT IFNULL(SUM(ca.MONTANT),0) AS MONTANTPAYE, co.* FROM comptes_eleves co "
                . "LEFT JOIN caisses ca ON co.IDCOMPTE = ca.COMPTE AND ca.VALIDE = 1 "
                . "GROUP BY co.IDCOMPTE) so "
                . "INNER JOIN eleves el ON el.IDELEVE = so.ELEVE "
                . "INNER JOIN classes cl  ON cl.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = cl.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "ORDER BY n.GROUPE DESC, n.NIVEAUHTML ASC, TRIM(el.NOM) ASC ";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
    }

    /**
     * Pour chque eleve de cette classe, obtenir le nombre de fois 
     * ou il s'est inscrite dans l'etablissement
     * @param type $idclasse
     */
    public function getNBInscription($idclasse) {
        $query = "SELECT el.*, "
                . "(SELECT COUNT(inscr.IDINSCRIPTION) FROM inscription inscr "
                . "WHERE inscr.IDELEVE = el.IDELEVE) AS NBINSCRIPTION "
                . "FROM eleves el "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :idclasse "
                . "ORDER BY el.NOM";
        return $this->query($query, ["idclasse" => $idclasse]);
    }

}
