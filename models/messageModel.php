<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messageModel
 *
 * @author JP
 */
class messageModel extends Model{
    protected $_table = "messages";
    protected $_key = "IDMESSAGE";
    
    public function __construct() {
        parent::__construct();
    }
    
}
