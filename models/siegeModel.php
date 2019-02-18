<?php

class siegeModel extends Model{
    protected $_table = "sieges";
    protected $_key = "IDSIEGE";
    
    public function __construct() {
        parent::__construct();
    }
    public function getLibelle(){
        return "LIBELLE";
    }
}
