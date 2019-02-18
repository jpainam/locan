<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of regionModel
 *
 * @author JP
 */
class regionModel extends Model{
    protected  $_table = "regions";
    protected  $_key = "IDREGION";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
