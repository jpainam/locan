<?php

class journalModel extends Model{
    protected $_table = "journals";
    protected $_key = "IDJOURNAL";
    
    public function __construct() {
       parent::__construct();
   }
   
   public function getLibelle(){
       return "LIBELLE";
   }
}
