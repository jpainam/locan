<?php

class compteController extends Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function modifier($idCompte){
        $view = new View();
        $content = $view->Render("compte" . DS . "modifier",false);
        $this->Assign("content", $content);
    }
    
    /**
     * Permet de modifier le telephone
     */
    public function telephone($idCompte){
        $view = new View();
        $content = $view->Render("compte" . DS . "modifiertelephone", false);
        $this->Assign("content", $content);
    }
    /**
     * Permet l'affichage des connexions
     */
    public function connexions(){
        $view = new View();
        $content = $view->Render("compte" . DS . "afficherconnexions", false);
    }
}
