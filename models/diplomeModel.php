<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of diplomeModel
 *
 * @author JP
 */
class diplomeModel extends Model {
    protected $_table = "diplomes";
    protected $_key = "IDDIPLOME";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
