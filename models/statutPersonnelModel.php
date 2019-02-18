<?php

class statutPersonnelModel extends Model{
    protected $_table = "statut_personnels";
    protected $_key = "IDSTATUTPERSONNEL";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
