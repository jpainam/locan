<?php

/* construit le tableau et affiche les lignes sur un font different */

final class Grid {
    /* ligne paire ou impaire */

    private $etat;
    /* Colonne qui doivent afficher les formats date */
    public $coldate;

    /** Donnees a afficher */
    private $data;
    /* Tableau de colonnne */
    private $colonnes;
    public $editbutton = FALSE;
    public $deletebutton = FALSE;
    public $editbuttontext;
    public $deletebuttontext;
    public $selectbutton = FALSE;
    public $id;
    public $checkedbutton; //Tableau de button deja cocher, liste des check a cocher pendant la construction
    public $formatdate = "short"; //short : Date sous trois format 01 Sept 2011 , long : Date sous tous les format 01 Septembre 2011

    /* Determine si on doit afficher les button d'action delete et edit dans une colonne */
    public $actionbutton = true;
    public $target;
    public $_key;

    /**
     * id de la table datatable a generer, valeur par defaut, id = databable
     * @var type chaine de caractere
     */
    public $dataTable = "dataTable";
    public $droitdelete = 101; //pour des questions de tests
    public $droitedit = 101; //pour des questions de tests

    function __construct($data, $id = 0) {
        $this->id = $id;
        $this->coldate = array();
        $this->etat = 0;

        /* Definition des object */
        $this->data = $data;
        $this->colonnes = new ArrayObject();
        $this->checkedbutton = array();
        $this->checkedbutton[] = -1;
    }

    private function contains($idcol) {
        foreach ($this->colonnes as $col) {
            if ($col->getid() == $idcol) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function getKey() {
        foreach ($this->colonnes as $col) {
            if ($col->getid() == $this->id) {
                return $col->datafield;
            }
        }
        die("Erreur fatale, il doit exister une colonne ID dans la datatable");
    }

    public function setColDate($i) {
        $this->coldate[count($this->coldate)] = $i;
    }

    /**
      param : $id = Id de la colonne, doit etre differente pour chaque colonne
      $txt = text tel qu'il doit etre afficher et vue par l'utilisateur
      $field = bind colonne, identique a celle defini dans la BD, peut etre numerique ou string
      $visible = valeur boolean, defini si la colonne doit etre hidden ou visible
     */
    public function addcolonne($id, $txt, $field, $visible = TRUE) {
        if (!$this->contains($id)) {
            $colonne = new Column($id, $txt, $field, $visible);
            $this->colonnes->append($colonne);
        } else {
            die("la table contient deja cette colonne id : " . $id);
        }
    }

    function getNbColonneVisible() {
        $i = 0;
        foreach ($this->colonnes as $col) {
            if ($col->visible) {
                $i++;
            }
        }
        return $i;
    }

    function display($largeur = '100%', $hauteur = '100%') {

        $this->_key = $this->getKey();


        if (!is_array($this->data)) {
            return false;
        }

        /* Obtenir le controller courant */
        global $url;
        $urlArray = explode("/", $url);
        $controller = $urlArray[0];

        $str = "";
        //Obtenir la colonne ou se cachera l'id
        //$id = $this->colonnes[$this->id]->getid();
        $str .= "<div id = 'grid' style=\"max-height:" . $hauteur . ";max-width:" . $largeur . "\">";
        /* table de donnees */
        $str .= "<table class=\"dataTable\" id=\"" . $this->dataTable . "\">";
        //AFFICHAGE DES COLONNES
        $str .= "<thead><tr>";
        if ($this->selectbutton) {
            $str .= "<th><input type=\"checkbox\" onchange=\"checkall()\" id = 'chkall'></th>";
        }
        foreach ($this->colonnes as $col) {
            if ($col->visible) {
                $str .= "<th>" . $col->text . "</th>";
            }
        }
        if ($this->actionbutton) {
            if ($this->editbutton || $this->deletebutton) {
                $str .= "<th></th>";
            }
        }
        $str .= "</tr></thead><tbody>";
        //AFFICHAGE DES LIGNES
        $line_color = "even";
        foreach ($this->data as $line) {
            $str .= "<tr>";
            $j = 0;
            if ($this->selectbutton) {

                /* if (in_array($line[$this->id], $this->checkedbutton)) {
                  print "<td><input type=\"checkbox\" name=\"chk[]\" checked = 'checked' value = \"" . $line[$this->id] . "\" /></td>";
                  } else
                  print "<td><input type=\"checkbox\" name=\"chk[]\" value = \"" . $line[$this->id] . "\" /></td>"; */
            }
            foreach ($this->colonnes as $col) {
                if ($col->visible) {
                    if (in_array($j, $this->coldate)) {
                        $d = new DateFR($line[$col->datafield]);
                        if ($this->formatdate == "long") {
                            $str .= "<td>" . $d->fullYear() . "</td>";
                        } else {
                            $str .= "<td>" . $d->getDateMessage(3) . "</td>";
                        }
                    } else {
                        $str .= "<td>" . $line[$col->datafield] . "</td>";
                    }
                }
                $j++;
            }
            if ($this->actionbutton) {

                if ($this->editbutton || $this->deletebutton) {
                    $str .= "<td style = 'width:50px;padding:0; margin:0;text-align:center;'>";
                    if ($this->editbutton) {
                        if (isAuth($this->droitedit)) {
                            $_url = url($controller, 'edit', $line[$this->_key]);
                            $str .= "<img style = 'cursor:pointer;' onclick = \"document.location='" . $_url . "';\""
                                    . " src = '" . SITE_ROOT . "public/img/edit.png' title = \"" . $this->editbuttontext . "\" />&nbsp;&nbsp;";
                        } else {
                            $str .= "<img style = 'cursor:pointer;' src = '" . SITE_ROOT . "public/img/edit_disabled.png' />&nbsp;";
                        }
                    }if ($this->deletebutton) {
                        if (isAuth($this->droitdelete)) {
                            $_url = url($controller, 'delete', $line[$this->_key]);
                            $str .= "<img style = 'cursor:pointer;' onclick = \"javascript:deleteRow('" . $_url . "', '" . $line[$this->_key] . "');\""
                                    . " src = '" . SITE_ROOT . "public/img/delete.png' title = \"" . $this->deletebuttontext . "\" />";
                        } else {
                            $str .= "&nbsp;<img style = 'cursor:pointer;' src = '" . SITE_ROOT . "public/img/delete_disabled.png' />";
                        }
                    }
                    $str .= "</td>";
                }
            }
            $this->etat++;
            $str .= "</tr>";
        }
        $nb = $this->getNbColonneVisible();
        if ($this->editbutton || $this->deletebutton)
            $nb += 1;
        if ($this->selectbutton)
            $nb += 1;
        $str .= "</tbody><tfoot><tr><td colspan = \"" . $nb . "\"></td></tr></tfoot>";
        $str .= "</table></div>";
        return $str;
    }

    /**
      Renvoit le nbre de donnees de la requete
     */
    function length() {
        if ($this->data instanceof ArrayObject)
            return $this->data->count();
        else
            return 0;
    }

}
