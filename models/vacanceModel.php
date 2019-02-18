<?php
class vacanceModel extends Model {
    protected $_table = "vacances";
    protected $_key = "IDVACANCE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
