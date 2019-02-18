<?php
class repertoireController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        if(!isAuth(206)){
            return;
        }
        $view = new View();
        $this->view->clientsJS("repertoire" . DS . "index");
        
        $rep = $this->Repertoire->selectAll();
        
        $repertoires = new Grid($rep, 1);
        $repertoires->actionbutton = false;
        $repertoires->addcolonne(0, "CIVILITE", "CIVILITE");
        $repertoires->addcolonne(1, "NOM", "NOM");
        $repertoires->addcolonne(2, "TELEPHONE", "TELEPHONE");
        $repertoires->addcolonne(3, "PORTABLE", "PORTABLE");
        $repertoires->addcolonne(4, "EMAIL", "EMAIL");
        $repertoires->dataTable = "tableRepertoire";
        
        $view->Assign("total", count($rep));
        $view->Assign("repertoires", $repertoires->display());
        $content = $view->Render("repertoire" . DS . "index", false);
        $this->Assign("content", $content);
    }
}
