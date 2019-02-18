<?php

/**
 * http://blog.lecacheur.com/2006/09/22/appliquer-le-modele-mvc-en-ajax/
 * <?php
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
  dododo;
  ?>
 */
class ajaxController extends Controller {

    public function __construct() {
        parent::__construct();
        //$c = new CO
    }

    /** Pour les onglets eleves */
    public function eleve($val) {
        $view = new View();
        $arr = array();
        $onglet1 = $view->Render("ajax" . DS ."80010", false);
        $onglet2 = $view->Render("ajax" . DS . "80011", false);
        $arr[0] = $onglet1;
        $arr[1] = $onglet2;
        print json_encode($arr);
    }
    
    public function personnel(){
        echo "JE SUIS FORT " . $this->request->ideleve;
    }

}
