<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messageEleveModel
 *
 * @author JP
 */
class messageEleveModel extends Model {

    protected $_table = "messages_eleves";
    protected $_key = "IDMESSAGEELEVE";

    public function __construct() {
        parent::__construct();
    }

}
