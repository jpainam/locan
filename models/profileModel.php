<?php

class profileModel extends Model{

    protected $_table = "profile";
    protected $_key = "IDPROFILE";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDroits($profile){
        $query = "SELECT LISTEDROIT FROM $this->_table WHERE $this->_key = :profile";
        return $this->single($query, ["profile" => $profile]);
    }
    
    public function getLibelle(){
        return "PROFILE";
    }
}
