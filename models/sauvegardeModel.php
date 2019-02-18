<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SauvegardeModel
 *
 * @author JP
 */
class sauvegardeModel extends Model{
    protected $_table = "sauvegardes";
    protected $_key = "IDSAUVEGARDE";
    
    public function __construct() {
        parent::__construct();
    }
    public function selectAll(){
        $query  = "SELECT * FROM `" . $this->_table ."` "
                . "ORDER BY DATESAUVEGARDE DESC";
        return $this->query($query);
    }
}
