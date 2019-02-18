<?php

class bulletinModel extends Model {

    protected $_table = "";

    public function __construct() {
        parent::__construct();
    }

    /**
     * Retourne des enregistrements correspondant aux ligne des bulletin 
     * pour cette classe, cet eleve a cette sequence
     * @param type $idclasse
     * @param type $ideleve
     * @param type $idsequence
     * @param int $idgroupe filtrer par groupe, $idgroupe est le groupe auxquel apartient la matiere
     */
    public function getSequenceNotes($idclasse, $ideleve, $idsequence, $idgroupe) {
        /* $query = "SELECT ens.*, mat.*, prof.*, g.DESCRIPTION AS GROUPELIBELLE "
          . "FROM enseignements ens "
          . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
          . "INNER JOIN personnels prof ON prof.IDPERSONNEL = ens.PROFESSEUR "
          . "INNER JOIN groupe g ON g.IDGROUPE = ens.GROUPE "
          . "WHERE ens.CLASSE = :idclasse AND ens.GROUPE = :idgroupe";
         */

        $query = "SELECT n.*";
        $params = ["idclasse" => $idclasse, "idgroupe" => $idgroupe];
        return $this->query($query, $params);
    }

    public function getTrimestreNotes($idclasse, $ideleve, $idtrimestre) {
        
    }

    /**
     * Creai la table temporaire pour cette classe a cette sequence
     * @param type $idclasse
     * IDELEVE, IDENSEIGNEMENT, NOTE DP, NOTE DH
     * S'il est absent, alors, retourner VIDE comme note DP et note DH,
     * cette note sera non comptabiliser, s'il a zero ou null, alors comptabiliser)
     * s'il est present, mettre null et remplacer par 0
     */
    public function createTMPNoteTable($idclasse, $idsequence) {

        $this->query("DROP TABLE IF EXISTS tmp_notes;");
        $this->query("DROP TEMPORARY TABLE IF EXISTS tmp");

        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp ("
                . "SELECT el.IDELEVE, ens.*, gr.*, mat.*, pers.CIVILITE, pers.NOM, pers.PRENOM, "
                . "el.NOM AS NOMEL, el.PRENOM AS PRENOMEL, el.DATENAISS AS DATENAISSEL, el.SEXE AS SEXEEL, "
                . "el.PHOTO AS PHOTOEL, el.MATRICULE AS MATRICULEEL, el.AUTRENOM AS AUTRENOMEL, el.LIEUNAISS AS LIEUNAISSEL, "
                # Note
                . "(SELECT IF(n.ABSENT = 1, '', n.NOTE) FROM notes n "
                . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                . "AND nota.SEQUENCE = :sequence1 "
                . "WHERE n.ELEVE = el.IDELEVE AND nota.ENSEIGNEMENT = ens.IDENSEIGNEMENT) AS SANOTE "
                . "FROM eleves el "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :classe "
                . "LEFT JOIN enseignements ens ON ens.CLASSE = i.IDCLASSE "
                . "INNER JOIN groupe gr ON gr.IDGROUPE = ens.GROUPE "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ens.PROFESSEUR "
                . "ORDER BY ens.GROUPE, mat.BULLETIN"
                . ");";

        $this->query($query, ["classe" => $idclasse,
            "sequence1" => $idsequence]);

        $query = "CREATE TABLE IF NOT EXISTS tmp_notes ("
                . "SELECT t.*, "
                . "CAST(IF(SANOTE = '' OR SANOTE IS NULL, '', SANOTE) AS DECIMAL(5,2)) AS MOYENNE "
                . "FROM tmp t ORDER BY t.BULLETIN"
                . ")";
        $this->query($query);
        $query = "ALTER TABLE `tmp_notes` ADD INDEX(`IDELEVE`, `IDENSEIGNEMENT`, `IDMATIERE`)";
        $this->query($query);
        # Prendre en compte les eleves qui n'ont aucune des deux notes
        # Ne pas considerer le calculs des coefficients
        $query = "UPDATE `tmp_notes` SET "
                . "COEFF = NULL, MOYENNE = NULL "
                . "WHERE (SANOTE IS NULL OR SANOTE = '')";
        $this->query($query);

        $query = "SELECT IDELEVE FROM tmp_notes WHERE MOYENNE IS NULL GROUP BY IDELEVE HAVING COUNT(*) > 8";
        $elevesclasse = $this->query($query);
        foreach ($elevesclasse as $el) {
            $this->query("DELETE FROM tmp_notes WHERE IDELEVE = :ideleve", ["ideleve" => $el['IDELEVE']]);
        }
        return true;
        # Supprimer les eleves non classes
        /* $query = "DELETE FROM tmp_notes "
          . "WHERE IDELEVE IN ("
          . "SELECT IDELEVE "
          . "FROM tmp_notes "
          . "WHERE MOYENNE IS NULL "
          . "GROUP BY IDELEVE HAVING(COUNT(*)) > 3 "
          . ")";
          return $this->query($query); */
        ##$this->pdo->exec("LOCK TABLES tmp_notes write;");
    }

    /**
     * Cette fonction utilise la table temporaire precedement cree pour 
     * obtenir les moyenne de classe, et classer les eleves
     */
    public function getNotesByEnseignements($idenseignement) {
        #Requete pour selectionner les notes sous la forme de 
        # ENSEIGNEMENT | DP | DH | MOY | COEF | TOTAL | RANG | MoyCl | MIN | MAX
        $query = "SELECT t.*,  "
                . "COEFF * MOYENNE AS TOTAL, "
                . "(SELECT AVG(MOYENNE) FROM tmp_notes t1 WHERE t1.IDENSEIGNEMENT = t.IDENSEIGNEMENT AND MOYENNE IS NOT NULL) AS MOYCL, "
                . "(SELECT MIN(MOYENNE) FROM tmp_notes t2 WHERE t2.IDENSEIGNEMENT = t.IDENSEIGNEMENT AND MOYENNE IS NOT NULL) AS NOTEMIN, "
                . "(SELECT MAX(MOYENNE) FROM tmp_notes t3 WHERE t3.IDENSEIGNEMENT = t.IDENSEIGNEMENT AND MOYENNE IS NOT NULL) AS NOTEMAX, "
                . "IF(MOYENNE <=> @_last_moy, @curRang := @curRang, @curRang := @_sequence) AS RANG, "
                . "@_sequence := @_sequence + 1, @_last_moy := MOYENNE "
                . "FROM tmp_notes t, (SELECT @curRang := 1, @_sequence := 1, @_last_moy := 0) r "
                . "WHERE t.IDENSEIGNEMENT = :enseignement "
                . "ORDER BY MOYENNE DESC";
        return $this->query($query, ["enseignement" => $idenseignement]);
    }

    /**
     * Obtenir le rang des eleves
     * Renvoie la liste des eleves, avec leur rang sequentielle et leur moyenne generale
     */
    public function getElevesRang() {
        $query = "SELECT IDELEVE, NOMEL, PRENOMEL, SEXEEL, PHOTOEL, DATENAISSEL, MATRICULEEL, LIEUNAISSEL, AUTRENOMEL, "
                . "MOYGENERALE, POINTS, SUMCOEFF, "
                . "CASE WHEN @_last_moy = MOYGENERALE THEN @curRang ELSE @curRang := @_sequence END AS RANG, "
                . "@_last_moy := MOYGENERALE, @_sequence := @_sequence + 1 "
                . "FROM ("
                . "SELECT IDELEVE, NOMEL, PRENOMEL, SEXEEL, PHOTOEL, DATENAISSEL, MATRICULEEL, LIEUNAISSEL, AUTRENOMEL, "
                . "SUM(MOYENNE*COEFF)/SUM(COEFF) AS MOYGENERALE, SUM(MOYENNE*COEFF) AS POINTS, "
                . "SUM(COEFF) AS SUMCOEFF "
                . "FROM tmp_notes GROUP BY IDELEVE ORDER BY MOYGENERALE DESC "
                . ") TOTALS, (SELECT @curRang := 1, @_last_moy := 0, @_sequence := 1) r";
        return $this->query($query);
    }

    public function getElevesRangAnnuel() {
        $query = "SELECT IDELEVE, NOMEL, PRENOMEL, SEXEEL, PHOTOEL, DATENAISSEL, MATRICULEEL, LIEUNAISSEL, AUTRENOMEL, "
                . "CAST(0 AS DECIMAL(5, 2)) AS MOYGENERALE, POINTS, SUMCOEFF, @_sequence AS RANG, "
                . "@_sequence := @_sequence + 1 "
                . "FROM ("
                . "SELECT IDELEVE, NOMEL, PRENOMEL, SEXEEL, PHOTOEL, DATENAISSEL, MATRICULEEL, LIEUNAISSEL, AUTRENOMEL, "
                . "SUM(MOYENNE*COEFF) AS POINTS, SUM(COEFF) AS SUMCOEFF "
                . "FROM tmp_notes GROUP BY IDELEVE"
                . ") TOTALS, (SELECT @_sequence := 1) r";
        return $this->query($query);
    }

    /**
     * Obtenir la moygenne generale de la classe, obtenir la moyenne min, obtenir la moyenne max
     */
    public function getGlobalMoyenne() {
        $query = "SELECT AVG(MOYGENERALE) AS MOYCLASSE, MIN(MOYGENERALE) AS MOYMIN, "
                . "MAX(MOYGENERALE) AS MOYMAX "
                . "FROM (SELECT SUM(MOYENNE*COEFF)/SUM(COEFF) AS MOYGENERALE "
                . "FROM tmp_notes GROUP BY IDELEVE ORDER BY MOYGENERALE DESC) TOTALS ";
        return $this->row($query);
    }

    /**
     * Supprime la table temporaire precedement creer
     */
    public function dropTMPNoteTable() {
        #$this->pdo->exec("UNLOCK TABLES tmp_notes write;");
        $query = "DROP TABLE IF EXISTS tmp_notes;";
        return $this->query($query);
    }

    public function dropTMPTable() {
        #$this->pdo->exec("UNLOCK TABLES tmp_notes write;");
        $query = "DROP TABLE IF EXISTS tmp_notes;";
        return $this->query($query);
    }

    public function selectAll() {
        $query = "SELECT t.*, el.NOM AS NOMEL, el.PRENOM AS PRENOMEL "
                . "FROM tmp_notes t "
                . "INNER JOIN eleves el ON el.IDELEVE = t.IDELEVE "
                . "ORDER BY el.NOM";
        return $this->query($query);
    }

    /**
     * FUNCTION POUR LE BULLETIN TRIMESTRIELLE
     */

    /**
     * 
     * @param type $idclasse
     * @param array $sequences les deux sequences du trimestre ordonner par ordre
     * @return type
     */
    public function createTrimestreTable($idclasse, $sequences) {

        $this->query("DROP TABLE IF EXISTS tmp_notes;");
        $this->query("DROP TEMPORARY TABLE IF EXISTS tmp");

        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp ("
                . "SELECT el.IDELEVE, el.NOM AS NOMEL, el.PRENOM AS PRENOMEL, el.SEXE AS SEXEEL, el.MATRICULE AS MATRICULEEL, "
                . "el.DATENAISS AS DATENAISSEL, el.PHOTO AS PHOTOEL, el.LIEUNAISS AS LIEUNAISSEL, el.AUTRENOM AS AUTRENOMEL, "
                . "ens.*, gr.*, mat.*, pers.CIVILITE, pers.NOM, pers.PRENOM, "
                # Note SEQ 1
                . "(SELECT IF(n.ABSENT = 1, '', n.NOTE) FROM notes n "
                . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                . "AND nota.SEQUENCE = :sequence1 "
                . "WHERE n.ELEVE = el.IDELEVE AND nota.ENSEIGNEMENT = ens.IDENSEIGNEMENT) AS SEQ1, "
                # Note SEQ 2
                . "(SELECT IF(n.ABSENT = 1, '', n.NOTE) FROM notes n "
                . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                . "AND nota.SEQUENCE = :sequence2 "
                . "WHERE n.ELEVE = el.IDELEVE AND nota.ENSEIGNEMENT = ens.IDENSEIGNEMENT) AS SEQ2 "
                . "FROM eleves el "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :classe "
                . "LEFT JOIN enseignements ens ON ens.CLASSE = i.IDCLASSE "
                . "INNER JOIN groupe gr ON gr.IDGROUPE = ens.GROUPE "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ens.PROFESSEUR "
                . "ORDER BY ens.GROUPE, mat.BULLETIN"
                . ");";

        $this->query($query, ["classe" => $idclasse,
            "sequence1" => $sequences[0], "sequence2" => $sequences[1]]);

        $query = "SELECT IDELEVE FROM tmp WHERE (SEQ1 IS NULL OR SEQ1 = '') GROUP BY IDELEVE HAVING COUNT(*) > 8";
        $elevesclasse = $this->query($query);
        foreach ($elevesclasse as $el) {
            $this->query("UPDATE tmp SET SEQ1 = NULL WHERE IDELEVE = :ideleve", ["ideleve" => $el['IDELEVE']]);
        }
        $query = "SELECT IDELEVE FROM tmp WHERE (SEQ2 IS NULL OR SEQ2 = '') GROUP BY IDELEVE HAVING COUNT(*) > 8";
        $elevesclasse = $this->query($query);
        foreach ($elevesclasse as $el) {
            $this->query("UPDATE tmp SET SEQ2 = NULL WHERE IDELEVE = :ideleve", ["ideleve" => $el['IDELEVE']]);
        }

        $query = "CREATE TABLE IF NOT EXISTS tmp_notes ("
                . "SELECT t.*, "
                . "CAST(IF(SEQ1 = '' OR SEQ1 IS NULL, IF(SEQ2 = '' OR SEQ2 IS NULL, '', SEQ2), "
                . "IF(SEQ2 = '' OR SEQ2 IS NULL, SEQ1, (SEQ1+SEQ2)/2)) AS DECIMAL(5,2)) AS MOYENNE "
                . "FROM tmp t ORDER BY t.BULLETIN"
                . ")";

        $this->query($query);
        $query = "ALTER TABLE `tmp_notes` ADD INDEX(`IDELEVE`, `IDENSEIGNEMENT`, `IDMATIERE`)";
        $this->query($query);
        # Prendre en compte les eleves qui n'ont aucune des deux notes
        # Ne pas considerer le calculs des coefficients
        $query = "UPDATE `tmp_notes` SET "
                . "COEFF = NULL, MOYENNE = NULL "
                . "WHERE (SEQ1 IS NULL OR SEQ1 = '') AND (SEQ2 IS NULL OR SEQ2 = '')";
        $this->query($query);
        $query = "SELECT IDELEVE FROM tmp_notes WHERE MOYENNE IS NULL GROUP BY IDELEVE HAVING COUNT(*) > 8";
        $elevesclasse = $this->query($query);
        foreach ($elevesclasse as $el) {
            $this->query("DELETE FROM tmp_notes WHERE IDELEVE = :ideleve", ["ideleve" => $el['IDELEVE']]);
        }
        return true;
        ##$this->pdo->exec("LOCK TABLES tmp_notes write;");
    }

    /**
     * FUNCTION POUR LE BULLETIN ANNUELLE
     */

    /**
     * 
     * @param type $anneeacad
     * @param array $array_of_sequences les  sequences de l annee academique ordonner par ordre
     * @return type
     */
    public function createAnnuelleTable($idclasse, $array_of_sequences = array()) {
        $params = ["classe" => $idclasse];

        $this->query("DROP TABLE IF EXISTS tmp_notes;");
        $this->query("DROP TEMPORARY TABLE IF EXISTS tmp");

        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp ("
                . "SELECT el.IDELEVE, el.NOM AS NOMEL, el.PRENOM AS PRENOMEL, el.SEXE AS SEXEEL, el.MATRICULE AS MATRICULEEL, "
                . "el.DATENAISS AS DATENAISSEL, el.PHOTO AS PHOTOEL, el.LIEUNAISS AS LIEUNAISSEL, el.AUTRENOM AS AUTRENOMEL, "
                . "ens.*, gr.*, mat.*, pers.CIVILITE, pers.NOM, pers.PRENOM, ";
        # Note SEQ 1, 2, 3 ... 6
        for ($i = 1; $i <= 6; $i++) {
            $query .= "(SELECT IF(n.ABSENT = 1, NULL, n.NOTE) FROM notes n "
                    . "INNER JOIN notations nota ON nota.IDNOTATION = n.NOTATION "
                    . "AND nota.SEQUENCE = :sequence$i "
                    . "WHERE n.ELEVE = el.IDELEVE AND nota.ENSEIGNEMENT = ens.IDENSEIGNEMENT) AS SEQ$i ,";
            $params["sequence$i"] = $array_of_sequences[$i - 1];
        }
        $query = substr($query, 0, strlen($query) - 1);

        $query .= "FROM eleves el "
                . "INNER JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.IDCLASSE = :classe "
                . "LEFT JOIN enseignements ens ON ens.CLASSE = i.IDCLASSE "
                . "INNER JOIN groupe gr ON gr.IDGROUPE = ens.GROUPE "
                . "INNER JOIN matieres mat ON mat.IDMATIERE = ens.MATIERE "
                . "INNER JOIN personnels pers ON pers.IDPERSONNEL = ens.PROFESSEUR "
                . "ORDER BY ens.GROUPE, mat.BULLETIN"
                . ");";

        $this->query($query, $params);

        # Remettre a null les sequence non classe
        for ($i = 1; $i <= 6; $i++) {
            $query = "SELECT IDELEVE FROM tmp WHERE SEQ$i IS NULL GROUP BY IDELEVE HAVING COUNT(*) > 10";
            $res = $this->query($query);
            foreach ($res as $e) {
                $this->query("UPDATE tmp SET SEQ$i = NULL WHERE IDELEVE = :ideleve", ["ideleve" => $e['IDELEVE']]);
            }
        }

        $query = "CREATE TABLE IF NOT EXISTS tmp_notes ("
                . "SELECT t.*, "
                . "IF(SEQ1 IS NOT NULL, @moy := @moy +SEQ1,@moy) AS T1, "
                . "IF(SEQ2 IS NOT NULL, @moy := @moy + SEQ2,@moy) AS T2, "
                . "IF(SEQ3 IS NOT NULL, @moy := @moy + SEQ3,@moy) AS T3, "
                . "IF(SEQ4 IS NOT NULL, @moy := @moy + SEQ4,@moy) AS T4, "
                . "IF(SEQ5 IS NOT NULL, @moy := @moy + SEQ5,@moy) AS T5, "
                . "IF(SEQ6 IS NOT NULL, @moy := @moy + SEQ6,@moy) AS T6, "
                . "IF(SEQ1 IS NOT NULL, @incr := @incr + 1,@incr) AS S1, "
                . "IF(SEQ2 IS NOT NULL, @incr := @incr + 1,@incr) AS S2, "
                . "IF(SEQ3 IS NOT NULL, @incr := @incr + 1,@incr) AS S3, "
                . "IF(SEQ4 IS NOT NULL, @incr := @incr + 1,@incr) AS S4, "
                . "IF(SEQ5 IS NOT NULL, @incr := @incr + 1,@incr) AS S5, "
                . "IF(SEQ6 IS NOT NULL, @incr := @incr + 1,@incr) AS S6, "
                . "IF(@incr = 0, IF(SEQ1 IS NULL AND SEQ2 IS NULL AND SEQ3 IS NULL "
                . "AND SEQ4 IS NULL AND SEQ5 IS NULL AND SEQ6 IS NULL, NULL, 0), @moy/@incr) AS MOYENNE , "
                . "@moy := 0, @incr := 0 "
                . "FROM tmp t, (SELECT @moy := 0, @incr := 0) r "
                . "ORDER BY t.BULLETIN"
                . ")";

        $this->query($query);

        $this->query("ALTER TABLE tmp_notes DROP T1, DROP T2, DROP T3, DROP T4, DROP T5, DROP T6,"
                . "DROP S1, DROP S2, DROP S3, DROP S4, DROP S5, DROP S6");

        $this->query("ALTER TABLE `tmp_notes` ADD INDEX(`IDELEVE`, `IDENSEIGNEMENT`, `IDMATIERE`)");
        # Prendre en compte les eleves qui n'ont aucune des  notes
        # Ne pas considerer le calculs des coefficients
        $query = "UPDATE `tmp_notes` SET "
                . "COEFF = NULL, MOYENNE = NULL "
                . "WHERE ";
        for($i = 1; $i <= 6; $i++){
            $query .= "(SEQ$i IS NULL OR SEQ$i = '') AND ";
        }
        $query = substr($query, 0, strlen($query) - 4);
        $this->query($query);
        
        $query = "SELECT IDELEVE FROM tmp_notes WHERE MOYENNE IS NULL GROUP BY IDELEVE HAVING COUNT(*) > 3";
        $elevesclasse = $this->query($query);
        foreach ($elevesclasse as $el) {
            $this->query("DELETE FROM tmp_notes WHERE IDELEVE = :ideleve", ["ideleve" => $el['IDELEVE']]);
        }
        return true;
        ##$this->pdo->exec("LOCK TABLES tmp_notes write;");
    }

    public function getRangMoyenneSequences($seqs = array()) {
        $query = "SELECT DISTINCT(ELEVE) AS IDELEVE, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq1) AS MOYSEQ1, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq11) AS RANGSEQ1, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq2) AS MOYSEQ2, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq22) AS RANGSEQ2, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq3) AS MOYSEQ3, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq33) AS RANGSEQ3, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq4) AS MOYSEQ4, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq44) AS RANGSEQ4, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq5) AS MOYSEQ5, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq55) AS RANGSEQ5, "
                . "(SELECT MOYENNE FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq6) AS MOYSEQ6, "
                . "(SELECT RANG FROM tmp_moy_seq tp WHERE tp.ELEVE = tmq.ELEVE AND tp.SEQUENCE = :seq66) AS RANGSEQ6 "
                . "FROM tmp_moy_seq tmq "
                . "ORDER BY MOYSEQ1  DESC";
        $arr = ["seq1" => $seqs[0], "seq11" => $seqs[0],
            "seq2" => $seqs[1], "seq22" => $seqs[1],
            "seq3" => $seqs[2], "seq33" => $seqs[2],
            "seq4" => $seqs[3], "seq44" => $seqs[3],
            "seq5" => $seqs[4], "seq55" => $seqs[4],
            "seq6" => $seqs[5], "seq66" => $seqs[5]];
        return $this->query($query, $arr);
    }

    public function createMoySequentielTable() {
        $this->query("DROP TABLE IF EXISTS tmp_moy_seq;");
        $query = "CREATE TABLE IF NOT EXISTS tmp_moy_seq("
                . "NUMERO INT(11) NOT NULL AUTO_INCREMENT,"
                . "ELEVE INT(11) NOT NULL,"
                . "MOYENNE DECIMAL(5,2) DEFAULT NULL,"
                . "RANG INT(11) DEFAULT NULL,"
                . "SEQUENCE INT(11) NOT NULL,"
                . "PRIMARY KEY(NUMERO))";
        return $this->query($query);
    }

    public function dropMoySequentielTable() {
        return $this->query("DROP TABLE IF EXISTS tmp_moy_seq;");
    }

    public function insertIntoMoySequentiel($params = array()) {
        $str = "";
        $val = "";
        foreach ($params as $key => $param) {
            $str .= " " . strtoupper($key) . ",";
            $val .= ":$key,";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $val = substr($val, 0, strlen($val) - 1);
        $query = "INSERT INTO  tmp_moy_seq($str) VALUES($val)";
        return $this->query($query, $params);
    }

}
