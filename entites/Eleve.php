<?php

class Eleve {

    
    public $matricule;
    public $nom;
    public $prenom;
    public $autrenom;
    public $sexe;
    public $photo;
    public $nationalite;
    public $datenaiss;
    public $lieunaiss;
    public $paysnaiss;
    public $provenance;
    public $redoublant;
    
    public $dateentree;
    public $datesortie;
    public $motifsortie;

    public function __construct($matricule, $nom, $prenom, $autrenom = "", $sexe = "M",
            $photo = "", $nationalite = null, $datenaiss = null, $lieunaiss = "", $paysnaiss = null, $dateentree = NULL, $provenance = null, $redoublant = false, $datesortie = null, $motifsortie = null) {
        if (is_null($dateentree)) {
            $this->dateentree = date("Y-m-d", time());
        }
        $this->matricule = $matricule;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->autrenom = $autrenom;
        $this->sexe = $sexe;
        $this->photo = $photo;
        $this->nationalite = $nationalite;
        $this->datenaiss = $datenaiss;
        $this->lieunaiss = $lieunaiss;
        $this->paysnaiss = $paysnaiss;
        $this->dateentree = $dateentree;
        $this->provenance = $provenance;
        $this->redoublant = $redoublant;
        $this->datesortie = $datesortie;
        $this->motifsortie = $motifsortie;
    }

}
