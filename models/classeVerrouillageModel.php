<?php

class classeVerrouillageModel extends Model {

    protected $_table = "classes_verrouillages";
    protected $_key = "IDVERROUILLAGECLASSE";

    public function __construct() {
        parent::__construct();
    }

    public function getClasses($idsequence) {
        $query = "SELECT cl.*, niv.*, cv.* "
                . "FROM classes cl "
                . "INNER JOIN niveau niv ON niv.IDNIVEAU = cl.NIVEAU "
                . "LEFT JOIN `" . $this->_table . "` cv ON cv.CLASSE = cl.IDCLASSE AND cv.SEQUENCE = :sequence "
                . "ORDER BY niv.GROUPE DESC, niv.NIVEAUHTML";
        return $this->query($query, ["sequence" => $idsequence]);
    }

}
