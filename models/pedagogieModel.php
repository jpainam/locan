<?php

class pedagogieModel extends Model {

    protected $_table = "pedagogies";
    protected $_key = "IDPEDAGOGIE";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Matiere pour laquelle il faut creer une table temporaire 
     * de couverture 
     * Si le nombre de lecon non fait est = 0, alors toutes les lecons sont faite et donc le chapitre
     */
    public function createTMPCouvertureTable($idmatiere) {
        $this->query("DROP TABLE IF EXISTS tmp_couvertures;");
        
        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp ("
                . "SELECT chap.*, ens.*, mat.LIBELLE AS MATIERELIBELLE, cl.LIBELLE AS CLASSELIBELLE, "
                . "prof.NOM AS NOMPROF, prof.PRENOM AS PRENOMPROF, "
                . "(SELECT COUNT(*) FROM programmations prog "
                    . "INNER JOIN lecons lec ON lec.IDLECON = prog.LECON "
                    . "WHERE lec.CHAPITRE = chap.IDCHAPITRE AND prog.ETAT = 0) "
                . "AS NONFAIT "
                . "FROM chapitres chap "
                . "INNER JOIN activites act ON act.IDACTIVITE = chap.ACTIVITE "
                . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = act.ENSEIGNEMENT AND ens.MATIERE = :matiere "
                . "INNER JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "INNER JOIN personnels prof ON prof.IDPERSONNEL = ens.PROFESSEUR "
                . ")";
         $this->query($query, ["matiere" => $idmatiere]);
         
        $query = "CREATE TABLE IF NOT EXISTS tmp_couvertures ("
                . "SELECT * FROM tmp"
                . ")";
        $this->query($query);   
    }
    /**
     * 
     * @param type $idsequence
     * @return type
     */
    public function getLeconsPrevues($idsequence){
        $query = "SELECT tp.*, "
                . "(SELECT COUNT(IDCHAPITRE) FROM tmp_couvertures t1 "
                    . "WHERE t1.SEQUENCE = :sequence1 GROUP BY t1.CLASSE) AS RAPPSEQ, "
                . "(SELECT COUNT(IDCHAPITRE) FROM tmp_couvertures t2 "
                    . "GROUP BY t2.CLASSE) AS RAPPANN "
                . "FROM tmp_couvertures tp "
                . "WHERE tp.SEQUENCE = :sequence2 "
                . "GROUP BY tp.CLASSE";
        return $this->query($query, ["sequence1" => $idsequence, 
            "sequence2" => $idsequence]);
    }
    /**
     * 
     * @param type $idsequence
     * @return type
     */
    public function getLeconsFaites($idsequence){
        $query = "SELECT tp.*, "
                . "(SELECT COUNT(IDCHAPITRE) FROM tmp_couvertures t1 "
                    . "WHERE t1.SEQUENCE = :sequence1 AND t1.NONFAIT = 0 "
                    . "GROUP BY t1.CLASSE"
                . ") AS RAPPSEQ, "
                . "(SELECT COUNT(IDCHAPITRE) FROM tmp_couvertures t2 "
                    . "WHERE t2.NONFAIT = 0 "
                    . "GROUP BY t2.CLASSE) AS RAPPANN "
                . "FROM tmp_couvertures tp "
                . "WHERE tp.SEQUENCE = :sequence2 "
                . "GROUP BY tp.CLASSE";
        return $this->query($query, ["sequence1" => $idsequence, 
            "sequence2" => $idsequence]);
    }
    
    public function dropTMPCouvertureTable() {
        #$this->pdo->exec("UNLOCK TABLES tmp_notes write;");
        $query = "DROP TABLE IF EXISTS tmp_couvertures;";
        return $this->query($query);
    }
    /**
     * 
     * @param type $idmatiere
     * @param type $idsequence
     * @return type
     */
    public function getHeuresPrevues($idmatiere, $idsequence){
        
        $query = "SELECT pla.*, ens.*, cl.IDCLASSE AS CLASSE, cl.LIBELLE AS CLASSELIBELLE, "
                . "mat.LIBELLE AS MATIERELIBELLE "
                . "FROM planifications pla "
                . "INNER JOIN enseignements ens ON ens.IDENSEIGNEMENT = pla.ENSEIGNEMENT "
                . "INNER JOIN classes cl ON cl.IDCLASSE = ens.CLASSE "
                . "INNER JOIN matieres mat ON ens.MATIERE = mat.IDMATIERE AND mat.IDMATIERE = :matiere "
                . "WHERE pla.SEQUENCE = :sequence";
        
        return $this->query($query, ["matiere" => $idmatiere, 
            "sequence" => $idsequence]);
    }

    /**
     * Se baser sur l'emploi du temps pour connaitre les absences
     * et soustraire cela des heures prevues
     */
    public function getHeuresFaites($idmatiere, $idsequence){
        
    }
}
