<?php

class responsableController extends Controller {

    private $comboCivilite;
    
    public function __construct() {
        parent::__construct();
        $this->loadModel("civilite");
        $data = $this->Civilite->selectAll();
        $this->comboCivilite = new Combobox($data, "comboCivilite", $this->Civilite->getKey(), $this->Civilite->getLibelle());
    }

    public function index() {
        $data = $this->Responsable->selectAll();
        $responsable = new Grid($data, 0);
        $responsable->addcolonne(0, "IDRESPONSABLE", "IDRESPONSABLE", false);
        $responsable->addcolonne(1, "Civ.", "CIVILITE");
        $responsable->addcolonne(2, "NOM & PRENOM", "CNOM");
        $responsable->addcolonne(3, "TELEPHONE", "TELEPHONE");
        $responsable->addcolonne(4, "PORTABLE", "PORTABLE");
        $responsable->addcolonne(5, "EMAIL", "EMAIL");
        $responsable->droitdelete = 318;
        $responsable->droitedit = 317;
        $responsable->actionbutton = true;
        $responsable->deletebutton = true;
        $responsable->editbutton = true;
        $responsable->dataTable = "responsableTable";
        
        $view = new View();
        $view->Assign("responsables", $responsable->display());
        $view->Assign("total", count($data));
        $content = $view->Render("responsable" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function delete($id){
        $this->Responsable->delete($id);
        header("Location:".Router::url("responsable"));
    }
    
    public function saisie(){
        //var_dump($this->request); //die();
        if(!empty($this->request->nom)){
            $acceptsms = (isset($this->request->acceptesms)? "1": "0");
            $params = ["civilite" => $this->request->comboCivilite,
                "nom" => $this->request->nom,
                "prenom" => $this->request->prenom,
                "adresse" => $this->request->adresse,
                "bp" => $this->request->bp,
                "portable" => $this->request->portable,
                "telephone" => $this->request->telephone,
                "email" => $this->request->email,
                "profession" => $this->request->profession,
                "acceptesms" => $acceptsms,
                "numsms" => $this->request->numsms
                    ];
            $this->Responsable->insert($params);
            header("Location:".Router::url("responsable"));
        }
        $view = new View();
        $view->Assign("comboCivilite", $this->comboCivilite->view());
        $content = $view->Render("responsable" . DS . "saisie", false);
        $this->Assign("content", $content);
    }
    
    public function edit($id){
        if(!empty($this->request->idresponsable)){
            $acceptsms = (isset($this->request->acceptesms)? "1" : "0");
            $params = ["civilite" => $this->request->comboCivilite,
                "nom" => $this->request->nom,
                "prenom" => $this->request->prenom,
                "adresse" => $this->request->adresse,
                "bp" => $this->request->bp,
                "portable" => $this->request->portable,
                "telephone" => $this->request->telephone,
                "email" => $this->request->email,
                "profession" => $this->request->profession,
                "acceptesms" => $acceptsms,
                "numsms" => $this->request->numsms
                    ];
            $this->Responsable->update($params, ["IDRESPONSABLE" => $this->request->idresponsable]);
            header("Location:".Router::url("responsable"));
        }
        $view = new View();
        $resp = $this->Responsable->findSingleRowBy(['IDRESPONSABLE' => $id]);
        $this->comboCivilite->selectedid = $resp['CIVILITE'];
        $view->Assign("comboCivilite", $this->comboCivilite->view());
        $view->Assign("resp", $resp);
        $content = $view->Render("responsable" . DS . "edit", false);
        $this->Assign("content", $content);
    }
}
