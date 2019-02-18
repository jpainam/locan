<?php

class planificationModel extends Model{
    protected $_table = "planifications";
    protected $_key = "IDPLANIFICATION";
    
    public function __construct() {
        parent::__construct();
    }
}
