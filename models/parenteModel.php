<?php

class parenteModel extends Model{
    protected $_table = "parente";
    protected  $_key = "LIBELLE";
    
    public function __construct() {
        parent::__construct();
    }
    
}
