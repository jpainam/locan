<?php

class droitModel extends Model {

    protected $_table = "droits";
    protected $_key = "IDDROIT";

    public function __construct() {
        parent::__construct();
    }

    public function selectAll() {
        $query = "SELECT * FROM droits "
                . "WHERE VERROUILLER = 0 "
                . "ORDER BY CODEDROIT ASC";
        return $this->query($query);
    }

    public function emptyDroits($profile) {
        $query = "DELETE FROM listedroits WHERE PROFILE = '$profile'";
         return $this->query($query);
    }

}
