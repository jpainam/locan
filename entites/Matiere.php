<?php

class Matiere {
   public $code;
   public $libelle;
   public function __construct($code, $libelle) {
       $this->code = $code;
       $this->libelle = $libelle;
   }

}
