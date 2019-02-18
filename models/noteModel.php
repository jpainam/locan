<?php

class noteModel extends Model {

    protected $_table = "notes";
    protected $_key = "IDNOTE";

    public function __construct() {
        parent::__construct();
    }

    public function getLibelle() {
        return "NOTE";
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT n.*, el.*, en.*, s.*, nt.*,"
                . "nt.VERROUILLER AS NOTATIONVERROUILLER, mat.BULLETIN "
                . "FROM `" . $this->_table . "` n "
                . "LEFT JOIN notations nt ON nt.IDNOTATION = n.NOTATION "
                . "LEFT JOIN eleves el ON el.IDELEVE = n.ELEVE "
                . "LEFT JOIN enseignements en ON en.IDENSEIGNEMENT = nt.ENSEIGNEMENT "
                . "INNER JOIN classes cl ON cl.IDCLASSE = en.CLASSE AND cl.ANNEEACADEMIQUE = :anneeacad "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = en.MATIERE "
                . "LEFT JOIN sequences s ON s.IDSEQUENCE = nt.SEQUENCE ";
        if (!isAuth(531)) {
            $query .= "INNER JOIN personnels pers ON pers.IDPERSONNEL = en.PROFESSEUR AND pers.USER = :restriction ";
            $params["restriction"] = $_SESSION['iduser'];
        }
        $query .= "WHERE $str "
                . "ORDER BY TRIM(el.NOM)";
        $params['anneeacad'] = $_SESSION['anneeacademique'];
        return $this->query($query, $params);
    }

    /**
     * Proceder a la suppression des notes lors de la desinscription
     * utiliser dans le controlleur inscription pour delete
     * @param type $idinscription
     */
    public function deleteNoteByDesinscription($periode, $eleve) {
        $query = "DELETE FROM notes "
                . "WHERE notes.NOTATION IN "
                . "(SELECT n.IDNOTATION FROM notations n "
                . "INNER JOIN sequences s ON s.IDSEQUENCE = n.SEQUENCE "
                . "INNER JOIN trimestres t ON t.IDTRIMESTRE = s.TRIMESTRE AND t.PERIODE = :periode) "
                . "AND notes.ELEVE = :eleve";
        return $this->query($query, ["periode" => $periode, "eleve" => $eleve]);
    }

    /**
     * Obtenir tous les notes de cette eleves pour cette classe
     * Utiliser dans eleve/index, onglet 5 pour afficher les notes qu'il a eu pendant une 
     * annee academique
     * @param type $ideleve
     * @param type $idclasse
     */
    public function getNotesEleveByClasse($ideleve, $idclasse) {
        if (isAuth(531)) {
            $query = "SELECT n.*, el.*, nota.*, c.*, seq.*, mat.*, mat.LIBELLE AS MATIERELIBELLE "
                    . "FROM notes n "
                    . "INNER JOIN eleves el ON el.IDELEVE = n.ELEVE "
                    . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                    . "INNER JOIN sequences seq ON seq.IDSEQUENCE = nota.SEQUENCE "
                    . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = nota.ENSEIGNEMENT AND ens.CLASSE = :idclasse "
                    . "INNER JOIN classes c ON c.IDCLASSE = ens.CLASSE "
                    . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                    . "WHERE n.ELEVE = :ideleve";
            return $this->query($query, ["idclasse" => $idclasse, "ideleve" => $ideleve]);
        } else {
            $query = "SELECT n.*, el.*, nota.*, c.*, seq.*, mat.*, mat.LIBELLE AS MATIERELIBELLE "
                    . "FROM notes n "
                    . "INNER JOIN eleves el ON el.IDELEVE = n.ELEVE "
                    . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                    . "INNER JOIN sequences seq ON seq.IDSEQUENCE = nota.SEQUENCE "
                    . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = nota.ENSEIGNEMENT AND ens.CLASSE = :idclasse "
                    . "INNER JOIN personnels p ON p.IDPERSONNEL = ens.PROFESSEUR AND p.USER = :restriction "
                    . "INNER JOIN classes c ON c.IDCLASSE = ens.CLASSE "
                    . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                    . "WHERE n.ELEVE = :ideleve";
            return $this->query($query, ["idclasse" => $idclasse, "ideleve" => $ideleve,
                        "restriction" => $_SESSION['iduser']]);
        }
    }

}
