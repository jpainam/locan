<?php

class Personnel {

    public $civilite;
    public $nom;
    public $prenom;
    public $autrenom;
    public $function;
    public $grade;
    public $datenaiss;
    public $telephone;
    public $portable;

    public function __construct($civilite, $nom, $prenom = "", $autrenom = "", $function = null,
            $grade = "", $datenaiss = null, $telephone = "", $portable = "") {
        $this->civilite = $civilite;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->autrenom = $autrenom;
        $this->function = $function;
        $this->grade = $grade;
        $this->datenaiss = $datenaiss;
        $this->telephone = $telephone;
        $this->portable = $portable;
    }

}
