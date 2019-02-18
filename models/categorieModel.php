<?php

class categorieModel extends Model{
    protected $_table = "categories";
    protected $_key = "IDCATEGORIE";
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
