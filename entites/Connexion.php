<?php

class Connexion {
   
    public $compte;
    public $datedebut;
    public $machine;
    public $connexion;
    public $datefin;
    public $deconnexion;
    public $ipsource;
    
    public function __construct($compte, $datedebut, $machine, $ipsource = "",
            $connexion = "Session en cours", $datefin = null, $deconnexion = "") {
        
        $this->compte = $compte;
        $this->datedebut = $datedebut;
        $this->machine = $machine;
        $this->connexion = $connexion;
        $this->datefin = $datefin;
        $this->deconnexion = $deconnexion;
        $this->ipsource = $ipsource;
    }

}
