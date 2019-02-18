<?php
class ferieModel extends Model{
    protected  $_table = "feries";
    protected  $_key = "IDFERIE";
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        
        return "LIBELLE";
    }
    
}
