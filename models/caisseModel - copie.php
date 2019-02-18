<?php

class caisseModel extends Model {

    protected $_table = "caisses";
    protected $_key = "IDCAISSE";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $datefin = date("Y-m-d", strtotime("+1 day", time()));
        $datedebut = date("Y-m-d", strtotime("-60 day", strtotime($datefin)));
        
        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU, cb.* "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "LEFT JOIN caisses_banques cb ON cb.IDCAISSEBANQUE = ca.IDCAISSE "
                . "WHERE (DATETRANSACTION BETWEEN :datedebut AND :datefin) AND ca.PERIODE = :anneeacad "
                . "ORDER BY ca.DATETRANSACTION DESC";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin, 
            "anneeacad" => $_SESSION['anneeacademique']]);
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, "
                . "p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU, n.NIVEAUHTML, cb.* "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN inscription i ON i.IDELEVE = el.IDELEVE AND i.ANNEEACADEMIQUE = ca.PERIODE "
                . "LEFT JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "LEFT JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "LEFT JOIN caisses_banques cb ON cb.IDCAISSEBANQUE = ca.IDCAISSE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE $str AND ca.PERIODE = :_anneecad "
                . "ORDER BY ca.DATETRANSACTION DESC";
        $params['_anneecad'] = $_SESSION['anneeacademique'];
        return $this->query($query, $params);
    }

    # Ajouter le responsable de cet eleve

    public function findSingleRowBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);


        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.*, resp.NOM AS NOMREP, "
                . "resp.PRENOM AS PRENOMREP, resp.PORTABLE AS PORTABLEREP, resp.NUMSMS AS "
                . "NUMSMS, resp.CIVILITE AS CIVILITEREP, cb.* "
                . "FROM `" . $this->_table . "` ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN responsable_eleve res_el ON res_el.IDELEVE = el.IDELEVE "
                . "LEFT JOIN caisses_banques cb ON cb.IDCAISSEBANQUE = ca.IDCAISSE "
                . "LEFT JOIN responsables resp ON resp.IDRESPONSABLE = res_el.IDRESPONSABLE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "WHERE $str AND ca.PERIODE = :_anneecad "
                . "ORDER BY ca.DATETRANSACTION DESC";
        
        $params['_anneecad'] = $_SESSION['anneeacademique'];
        return $this->row($query, $params);
    }

    public function getOperationsEncours($datedu, $dateau) {
        if (empty($datedu)) {
            $datedu = "1970-01-01";
        }
        if (empty($dateau)) {
            $dateau = "2039-01-01";
        }else{
            $dateau = date("Y-m-d", strtotime("+1 day", strtotime($dateau)));
        }

        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE ca.VALIDE = 0 AND ca.DATETRANSACTION BETWEEN :datedu AND :dateau "
                . "AND ca.PERIODE = :anneecad "
                . "ORDER BY ca.DATETRANSACTION DESC ";
        return $this->query($query, ["datedu" => $datedu, "dateau" => $dateau, 
            "anneecad" =>$_SESSION['anneeacademique']]);
    }

    public function getOperationsValidees($datedu, $dateau) {
        if (empty($datedu)) {
            $datedu = "1970-01-01";
        }
        if (empty($dateau)) {
            $dateau = "2039-01-01";
        }else{
            $dateau = date("Y-m-d", strtotime("+1 day", strtotime($dateau)));
        }

        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE ca.VALIDE = 1 AND ca.DATETRANSACTION BETWEEN :datedu AND :dateau "
                . "AND ca.PERIODE = :anneeacad "
                . "ORDER BY ca.DATETRANSACTION DESC ";
        return $this->query($query, ["datedu" => $datedu, "dateau" => $dateau, 
            "anneeacad" => $_SESSION['anneeacademique']]);
    }

    public function getOperationsPercues($datedu, $dateau) {
        if (empty($datedu)) {
            $datedu = "1970-01-01";
        }
        if (empty($dateau)) {
            $dateau = "2039-01-01";
        }else{
            $dateau = date("Y-m-d", strtotime("+1 day", strtotime($dateau)));
        }

        $query = "SELECT ca.*, co.*, el.NOM as NOMEL, el.PRENOM AS PRENOMEL, p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG,"
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE ca.PERCUPAR IS NULL AND ca.DATETRANSACTION BETWEEN :datedu AND :dateau "
                . "AND ca.PERIODE = :anneeacad "
                . "ORDER BY ca.DATETRANSACTION DESC";
        return $this->query($query, ["datedu" => $datedu, "dateau" => $dateau, 
            "anneeacad" => $_SESSION['anneeacademique']]);
    }

    public function getOperationsByJour($datedebut, $datefin) {
        if (empty($datefin)) {
            $datefin = date("Y-m-d", strtotime("+1 day", strtotime($datedebut)));
        }else{
            $datefin = date("Y-m-d", strtotime("+1 day", strtotime($datefin)));
        }
        $query = "SELECT ca.*, co.*, el.NOM AS NOMEL, el.PRENOM AS PRENOMEL, "
                . "p.NOM AS NOMENREG, p.PRENOM AS PRENOMENREG, "
                . "p2.NOM AS NOMPERCU, p2.PRENOM AS PRENOMPERCU "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE "
                . "INNER JOIN eleves el ON el.IDELEVE = co.ELEVE "
                . "LEFT JOIN personnels p ON p.IDPERSONNEL = ca.ENREGISTRERPAR "
                . "LEFT JOIN personnels p2 ON p2.IDPERSONNEL = ca.PERCUPAR "
                . "WHERE ca.DATETRANSACTION BETWEEN :datedebut AND :datefin "
                . "AND ca.PERIODE = :anneeacad "
                . "ORDER BY ca.DATETRANSACTION DESC, el.NOM";
        return $this->query($query, ["datedebut" => $datedebut, "datefin" => $datefin, 
            "anneeacad" => $_SESSION['anneeacademique']]);
    }

    /**
     * 
     * @param type $datedu
     * @param type $dateau
     * @return type
     */
    public function getMontantTotaux($datedu = "", $dateau = "") {
        if (empty($datedu)) {
            $datedu = "1970-01-01";
        }
        if (empty($dateau)) {
            $dateau = "2039-01-01";
        }else{
            $dateau = date("Y-m-d", strtotime("+1 day", strtotime($dateau)));
        }

        $query = "SELECT IFNULL((SELECT SUM(MONTANT) FROM caisses WHERE VALIDE = 0 AND DATETRANSACTION BETWEEN :datedu1 AND :dateau1 "
                . "AND PERIODE = :anneeacad1), 0) AS MONTANTNONVALIDE, "
                . "IFNULL((SELECT SUM(MONTANT) FROM caisses WHERE PERCUPAR IS NULL AND DATETRANSACTION BETWEEN :datedu2 AND :dateau2 "
                . "AND PERIODE = :anneeacad2), 0) AS MONTANTNONPERCU, "
                . "IFNULL((SELECT SUM(MONTANT) FROM caisses WHERE VALIDE = 1 AND DATETRANSACTION BETWEEN :datedu3 AND :dateau3 "
                . "AND PERIODE = :anneeacad3), 0) AS MONTANTVALIDE ";

        return $this->row($query, ["datedu1" => $datedu, "dateau1" => $dateau,
                    "datedu2" => $datedu, "dateau2" => $dateau, "datedu3" => $datedu, "dateau3" => $dateau, 
            "anneeacad1" => $_SESSION['anneeacademique'], "anneeacad2" => $_SESSION['anneeacademique'],
            "anneeacad3" => $_SESSION['anneeacademique']]);
    }

    /**
     * Renvoyer les operation caisse de credit 
     * Union
     * les frais scolaires a paye triee par date
     * @param type $ideleve
     */
    public function getOperationsCaisse($ideleve) {
        $query = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_caisses("
                . "SELECT t.* FROM ( "
                . "SELECT ca.DATETRANSACTION AS DATETR, ca.REFCAISSE AS REFCAISSE, ca.TYPE AS TYPE, "
                . "ca.REFTRANSACTION AS REFTRANSACTION, "
                . "ca.DESCRIPTION AS LIBELLE, IF(ca.TYPE = 'D', ca.MONTANT, '') AS DEBIT, "
                . "IF(ca.TYPE = 'C', ca.MONTANT, '') AS CREDIT, n.NIVEAUHTML "
                . "FROM `" . $this->_table . "` ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE AND co.ELEVE = :ideleve "
                . "INNER JOIN inscription i ON i.IDELEVE = co.ELEVE AND i.ANNEEACADEMIQUE = ca.PERIODE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "WHERE ca.VALIDE = 1 "
                . "UNION "
                . "SELECT f.ECHEANCES AS DATETR, CONCAT(SUBSTRING(f.DESCRIPTION, 1, 5),f.IDFRAIS) AS REFCAISSE, "
                . "'D' AS TYPE, f.IDFRAIS AS REFTRANSACTION, f.DESCRIPTION AS LIBELLE, f.MONTANT, '' AS CREDIT, n.NIVEAUHTML "
                . "FROM frais f "
                . "INNER JOIN inscription i ON i.IDELEVE = :ideleve2 AND f.CLASSE = i.IDCLASSE "
                . "INNER JOIN classes cl ON cl.IDCLASSE = i.IDCLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "WHERE f.ECHEANCES <= CURDATE() "
                . ") AS t "
                . ");";

        $this->query($query, ["ideleve" => $ideleve, "ideleve2" => $ideleve]);

        return $this->query("SELECT * FROM tmp_caisses ORDER BY DATETR ASC");
    }
    
    public function getMontantPayer($ideleve, $anneeacad = ""){
        if(empty($anneeacad)){
            $anneeacad = $_SESSION['anneeacademique'];
        }
        $query = "SELECT SUM(MONTANT) AS MONTANTPAYER "
                . "FROM caisses ca "
                . "INNER JOIN comptes_eleves co ON co.IDCOMPTE = ca.COMPTE AND co.ELEVE = :ideleve "
                . "WHERE ca.PERIODE = :anneeacad";
        return $this->row($query, ["ideleve" => $ideleve, "anneeacad" => $anneeacad]);
    }
    
    public function insertBordereauBanque($idcaisse, $bordereau){
        $query = "INSERT INTO caisses_banques(IDCAISSEBANQUE, BORDEREAUBANQUE) VALUES(:caisse, :bordereau)";
        return $this->query($query, ['caisse' => $idcaisse, "bordereau" => $bordereau]);
    }

}
