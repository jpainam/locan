<?php

class recapitulatifBulletinModel extends Model {

    protected $_table = "recapitulatifs_bulletins";
    protected $_key = "IDRECAPITULATIFBULLETIN";

    public function __construct() {
        parent::__construct();
    }

    public function getSyntheseTrimestre($idclasse, $array_of_sequences) {
        $query = "SELECT (t1.MOY1 + t2.MOY2)/2 AS MOYCLASSE "
                . "FROM (SELECT MOYCLASSE AS MOY1, rb.* FROM recapitulatifs_bulletins rb WHERE rb.CLASSE = :idclasse1 AND rb.SEQUENCE = :seq1) t1, "
                . "(SELECT MOYCLASSE AS MOY2, rb.* FROM recapitulatifs_bulletins rb WHERE rb.CLASSE = :idclasse2 AND rb.SEQUENCE = :seq2) t2 "
                . "WHERE t1.CLASSE = t2.CLASSE";
        
        return $this->row($query, ["idclasse1" => $idclasse, "idclasse2" => $idclasse,
                    "seq1" => $array_of_sequences[0], "seq2" => $array_of_sequences[1]]);
    }

}
