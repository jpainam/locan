<?php
class typeNoteModel extends Model{
    protected  $_table = "type_notes";
    protected  $_key = "IDTYPENOTE";
    
    public function __construct() {
       parent::__construct();
   }
   
   public function getLibelle(){
       return "TYPE";
   }
}
