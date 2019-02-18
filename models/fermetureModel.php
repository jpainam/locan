<?php
class fermetureModel extends Model{
    protected  $_table = "fermetures";
    protected  $_key = "IDFERMETURE";
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getLibelle(){
        return "LIBELLE";
    }
}
