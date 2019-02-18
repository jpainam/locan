<?php

class Combobox {
    /**
     *Donne est execute par 
     * @var type 
     */
    private $data;
    public $id; //Colonne contenant le value des <option value = row[id]>, cache a l'utilisateur
    /**
     * Colonne visible a l'utilisateur, afficher entre les <option>row[show]<option>
     * @var string
     */
    public $show;
    /**
     * name du <select name = name>
     * @var int 
     */
    public $name;
    /**
     * Information a afficher en premier dans le select (premier option)
     * @var int 
     */
    public $first;
    public $selected; //Existe t-il un element selectionner au depart TRUE ou FALSE
    public $selectedid; //Si selected = TRUE, indiquer l'identifiant de cet element qui devrai etre selectionner par defaut
    /**
     *  Precise s'il ya possibilite de choisir en dernier lieu ---Autre---
     * @var type boolean
     * default : false
     */
    public $other = FALSE;
    public $disabled = false;

    /* Id utiliser, meme chose pour name */
    public $idname;
    /**
     * Text a afficher s'il l'option autre existe
     * @var type 
     */
    public $textother = "--Autre | Pr&eacute;ciser--"; 
    /**
     *Fonction appelee lorsque la valeur change
     * @var type 
     */
    public $onchange = "";  
    /**
     * Ce champ est il obligatoire, utilise pour le HTML5
     * @var type 
     */
    public $required = false;

    function __construct($data, $name = '', $id = "", $show = '', $selected = FALSE, $select = 0) {
        $this->first = "";
        $this->selected = $selected;
        $this->id = $id;
        $this->show = $show;
        $this->name = $name;
        $this->idname = $name;
        $this->selectedid = $select;
        $this->data = $data;
    }

    function view($width = '100%') {

        if (is_null($this->data) || empty($this->data)) {
            return "<p class=\"infos\">Aucun enregistrement</p>";
        }
        if (!count($this->data) && !$this->other) {
            return "<p class=\"infos\">Aucun enregistrement</p>";
        }
        $str = "";
        $dis = "";
        if ($this->disabled) {
            $dis = 'disabled';
        }
        $req = "";
        
        if($this->required){
            $req = 'required';
        }

        $str .= "<select $dis $req name=\"" . $this->name . "\"  " . (!empty($this->onchange) ? "onChange ='" . $this->onchange . "'" : "") .
                " style=\"width:" . $width . "\" id = '" . $this->idname . "'>";
        if (!empty($this->first)) {
            $str .= "<option value=\"\">" . $this->first . "</option>";
        }
        if (count($this->data) > 0) {
            foreach ($this->data as $row) {
                $show = "";
                if (is_array($this->show)) {
                    foreach ($this->show as $s) {
                        $show .= $row[$s] . " # ";
                    }
                    $show = substr($show, 0, strlen($show) - 2);
                } else {
                    $show = $row[$this->show];
                }

                if (isset($this->selectedid) && !strcasecmp($row[$this->id], $this->selectedid)) {
                    $str .= "<option value=\"" . $row[$this->id] . "\" selected = 'selected'>" . $show . "</option>";
                } else {
                    $str .= "<option value=\"" . $row[$this->id] . "\">" . $show . "</option>";
                }
            }
        }
        if ($this->other) {
            $str .= "<option value='other'>" . $this->textother . "</option>";
        }
        $str .= "</select>";
        return $str;
    }

}
