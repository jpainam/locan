<?php

class Column {

    private $id;
    public $text; //le libelle de la colonne
    public $datafield;  //le champ de la DS liee a cette colonne
    public $maxwidth = "0px";  //largeur maximale de la conne (px,pt,em...)
    public $visible; //definit si la colonne sera visible ou non;

    //constructeur permet d'initaliser les membres dde la classe

    function __construct($idv, $textv = "", $fieldv = "", $isvisible = TRUE) {
        $this->id = $idv;
        $this->text = $textv;
        $this->datafield = $fieldv;
        $this->visible = $isvisible;
    }

    function getid() {
        return $this->id;
    }

}
