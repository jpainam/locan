<?php

class notificationBulletinModel extends Model {

    protected $_table = "notifications_bulletins";
    protected $_key = "IDNOTIFICATIONBULLETIN";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT nt.*, "
                . "cl.*, n.*, seq.*,seq.LIBELLE AS LIBELLESEQUENCE, p.* "
                . "FROM `" . $this->_table . "` nt "
                . "INNER JOIN classes cl ON cl.IDCLASSE = nt.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "INNER JOIN sequences seq ON seq.IDSEQUENCE = nt.SEQUENCE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = nt.REALISERPAR "
                . "ORDER BY nt.DATENOTIFICATION DESC";

        return $this->query($query);
    }

    public function findBy($conditions = array()) {
        $str = "";
        $params = array();
        foreach ($conditions as $key => $condition) {
            $str .= " $key = :$key AND ";
            $params[$key] = $condition;
        }
        $str = substr($str, 0, strlen($str) - 4);
        $query = "SELECT nt.*, "
                . "cl.*, n.*, seq.*,seq.LIBELLE AS LIBELLESEQUENCE, p.* "
                . "FROM `" . $this->_table . "` nt "
                . "INNER JOIN classes cl ON cl.IDCLASSE = nt.CLASSE "
                . "INNER JOIN niveau n ON n.IDNIVEAU = cl.NIVEAU "
                . "INNER JOIN sequences seq ON seq.IDSEQUENCE = nt.SEQUENCE "
                . "INNER JOIN personnels p ON p.IDPERSONNEL = nt.REALISERPAR "
                . "WHERE $str "
                . "ORDER BY nt.DATENOTIFICATION DESC";

        return $this->query($query, $params);
    }

}
