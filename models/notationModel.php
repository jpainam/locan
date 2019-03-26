<?php

# Droit pour limiter les classes dans lequell il intervient
# Droit 531

class notationModel extends Model {

    protected $_table = "notations";
    protected $_key = "IDNOTATION";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        if (isAuth(531)) {
            $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                    . "FROM `" . $this->_table . "` n "
                    . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                    . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
            return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique']]);
        } else {
            $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                    . "FROM `" . $this->_table . "` n "
                    . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                    . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
            return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'],
                        "restriction" => $_SESSION['iduser']]);
        }
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
            $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                    . "FROM `" . $this->_table . "` n "
                    . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                    . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "LEFT JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                    . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE "
                    . "WHERE $str";
            return $this->query($query, array_merge($params, ["anneeacad" => $_SESSION['anneeacademique']
            ]));
        } else {
            $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                    . "FROM `" . $this->_table . "` n "
                    . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                    . "LEFT JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                    . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE "
                    . "WHERE $str";
            return $this->query($query, array_merge($params, ["anneeacad" => $_SESSION['anneeacademique'],
                        "restriction" => $_SESSION['iduser']
            ]));
        }
    }

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT n.*, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, niv.*, m.LIBELLE AS MATIERELIBELLE "
                . "FROM `" . $this->_table . "` n "
                . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE "
                . "WHERE $str";
        return $this->row($query, $params);
    }

    /**
     * Obtient les information concernant des notation 
     * en se basant sur la matieres enseignees, utilise pour la methode note/statistique par matiere
     * 
     */
    public function getNotationsByMatieresByPeriode($idmatiere, $periode) {
        if (isAuth(531)) {
            $query = "SELECT n.*, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, ni.*, "
                    . "s.LIBELLE AS SEQUENCELIBELLE, p.* "
                    . "FROM notations n "
                    . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE AND n.SEQUENCE = :sequence "
                    . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT AND e.MATIERE = :idmatiere "
                    . "LEFT JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN niveau ni ON ni.IDNIVEAU = c.NIVEAU ";

            return $this->query($query, ['idmatiere' => $idmatiere, "sequence" => $periode]);
        } else {
            $query = "SELECT n.*, "
                    . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                    . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                    . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                    . "c.*, c.LIBELLE AS CLASSELIBELLE, ni.*, "
                    . "s.LIBELLE AS SEQUENCELIBELLE, p.*,  cy.DESCRIPTIONHTML AS CYCLEHTML "
                    . "FROM notations n "
                    . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE AND n.SEQUENCE = :sequence "
                    . "INNER JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT AND e.MATIERE = :idmatiere "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN cycles cy ON cy.IDCYCLE = c.CYCLE "
                    . "INNER JOIN niveau ni ON ni.IDNIVEAU = c.NIVEAU "
                    . "ORDER BY cy.IDCYCLE ASC, ni.GROUPE DESC, ni.NIVEAUHTML ASC";
            return $this->query($query, ['idmatiere' => $idmatiere, "sequence" => $periode,
                        "restriction" => $_SESSION['iduser']]);
        }
    }

    public function getNotationsByClasse($idclasse) {
        $params = ["anneeacad" => $_SESSION['anneeacademique'], "idclasse" => $idclasse];
        $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
        if (!isAuth(531)) {
            $query .= "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction ";
            $params['restriction'] = $_SESSION['iduser'];
        }
        $query .= "WHERE c.IDCLASSE = :idclasse ";
        return $this->query($query, $params);
    }

    public function getNotationsByPeriode($periode) {
        $params = ["anneeacad" => $_SESSION['anneeacademique'], "periode" => $periode];
        $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
        if (!isAuth(531)) {
            $query .= "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction ";
            $params['restriction'] = $_SESSION['iduser'];
        }
        $query .= "WHERE n.SEQUENCE = :periode ";
        return $this->query($query, $params);
    }

    public function getNotationsByClasseByPeriode($idclasse, $periode) {
        $params = ["anneeacad" => $_SESSION['anneeacademique'], "idclasse" => $idclasse,
            "periode" => $periode];
        $query = "SELECT n.*, n.VERROUILLER AS NOTATIONVERROUILLER, "
                . "(SELECT MAX(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMAX, "
                . "(SELECT MIN(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMIN, "
                . "(SELECT AVG(NOTE) FROM notes WHERE n.IDNOTATION = notes.NOTATION AND notes.ABSENT != 1) AS NOTEMOYENNE, "
                . "e.*, s.*, s.LIBELLE AS SEQUENCELIBELLE, "
                . "c.*, c.LIBELLE AS CLASSELIBELLE, m.BULLETIN, m.LIBELLE AS MATIERELIBELLE, niv.* "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN enseignements e ON e.IDENSEIGNEMENT = n.ENSEIGNEMENT "
                . "LEFT JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE AND c.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = c.NIVEAU "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE ";
        if (!isAuth(531)) {
            $query .= "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction ";
            $params['restriction'] = $_SESSION['iduser'];
        }
        $query .= "WHERE c.IDCLASSE = :idclasse AND n.SEQUENCE = :periode";
        return $this->query($query, $params);
    }

    public function getEnseignementNonNote($idclasse, $idsequence) {
        if (isAuth(531)) {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "WHERE e.CLASSE = :classe AND e.IDENSEIGNEMENT NOT IN "
                    . "(SELECT ENSEIGNEMENT FROM notations WHERE SEQUENCE = :sequence) "
                    . "ORDER BY m.LIBELLE";

            $params = ["classe" => $idclasse, "sequence" => $idsequence];
        } else {
            $query = "SELECT e.*, m.LIBELLE AS MATIERELIBELLE, m.*,"
                    . " p.*, c.*, c.LIBELLE AS CLASSELIBELLE, g.DESCRIPTION "
                    . "FROM enseignements e "
                    . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = e.PROFESSEUR AND p.USER = :restriction "
                    . "INNER JOIN classes c ON c.IDCLASSE = e.CLASSE "
                    . "INNER JOIN groupe g ON g.IDGROUPE = e.GROUPE "
                    . "WHERE e.CLASSE = :classe AND e.IDENSEIGNEMENT NOT IN "
                    . "(SELECT ENSEIGNEMENT FROM notations WHERE SEQUENCE = :sequence) "
                    . "ORDER BY m.LIBELLE";

            $params = ["classe" => $idclasse, "sequence" => $idsequence, "restriction" => $_SESSION['iduser']];
        }
        return $this->query($query, $params);
    }
    
    # seq.LIBELLE AS SEQUENCELIBELLE WHERE seq.IDSEQUENCE = :idsequence1
    public function getNotesNonSaisiesByPeriode($idsequence){
        $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, "
                . "cl.*, pers.* "
                . "FROM enseignements e "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = e.CLASSE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = e.PROFESSEUR "
                . "WHERE cl.ANNEEACADEMIQUE = :anneeacad "
                . "AND e.IDENSEIGNEMENT NOT IN ("
                . "SELECT ENSEIGNEMENT FROM notations n "
                . "WHERE n.SEQUENCE = :idsequence2)";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], 
             "idsequence2" => $idsequence]);
    }
    public function getNotesNonSaisiesByClasse($idclasse){
           $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, cl.*, pers.* "
                . "FROM enseignements e "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = e.CLASSE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = e.PROFESSEUR "
                . "WHERE cl.IDCLASSE = :idclasse AND e.IDENSEIGNEMENT NOT IN ("
                . "SELECT ENSEIGNEMENT FROM notations n "
                   . "INNER JOIN sequences seq ON seq.IDSEQUENCE = n.SEQUENCE "
                   . "INNER JOIN trimestres tr ON tr.IDTRIMESTRE = seq.TRIMESTRE "
                   . "WHERE tr.PERIODE = :anneeacad)";
        return $this->query($query, ["anneeacad" => $_SESSION['anneeacademique'], "idclasse" => $idclasse]);
    }
    
    public function getNotesNonSaisiesByClasseByPeriode($idclasse, $idsequence){
         $query = "SELECT e.*, m.*, m.LIBELLE AS MATIERELIBELLE, cl.*, pers.*, seq.LIBELLE AS SEQUENCELIBELLE "
                . "FROM enseignements e "
                 . "LEFT JOIN sequences seq ON seq.IDSEQUENCE = :idsequence1 "
                . "INNER JOIN matieres m ON m.IDMATIERE = e.MATIERE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = e.CLASSE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = e.PROFESSEUR "
                . "WHERE cl.IDCLASSE = :idclasse AND e.IDENSEIGNEMENT NOT IN ("
                . "SELECT ENSEIGNEMENT FROM notations n "
                . "WHERE n.SEQUENCE = :idsequence2 )";
        return $this->query($query, ["idclasse" => $idclasse, 
            'idsequence1' => $idsequence, 'idsequence2' => $idsequence]);
    }

}
