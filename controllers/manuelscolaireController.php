<?php

class manuelscolaireController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $this->loadModel("horaire");
        $data = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($data, "comboClasses", $this->Classe->getKey(), ["LIBELLE", "NIVEAUSELECT"]);
    }

    public function index() {
        if (!isAuth(245)) {
            return;
        }
        $this->view->clientsJS("manuelscolaire" . DS . "index");
        $view = new View();
        $manuels = $this->Manuelscolaire->selectAll();
        $view->Assign("manuels", $manuels);
        $content = $view->Render("manuelscolaire" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function saisie() {
        $this->view->clientsJS("manuelscolaire" . DS . "saisie");
        $view = new View();
        $content = $view->Render("manuelscolaire" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajax() {
        $action = $this->request->action;
        $json = array();
        $view = new View();
        switch ($action) {
            case "ajout":
                $params = array(
                    "titre" => $this->request->titre,
                    "editeurs" => $this->request->editeurs,
                    "auteurs" => $this->request->auteurs,
                    "prix" => $this->request->prix);
                $this->Manuelscolaire->insert($params);
                break;
            case "fetch_edit":
                $manuel = $this->Manuelscolaire->get($this->request->idmanuel);
                $json[0] = $manuel['TITRE'];
                $json[1] = $manuel['EDITEURS'];
                $json[2] = $manuel['AUTEURS'];
                $json[3] = $manuel["PRIX"];
                break;
            case "submit_edit":
                $params = array(
                    "titre" => $this->request->titre,
                    "editeurs" => $this->request->editeurs,
                    "auteurs" => $this->request->auteurs,
                    "prix" => $this->request->prix);
                $this->Manuelscolaire->update($params, ["IDMANUELSCOLAIRE" => $this->request->idmanuel]);
               break;
        }
        if($action == "ajout" || $action == "submit_edit"){
            $manuels = $this->Manuelscolaire->selectAll();
            $view->Assign("manuels", $manuels);
            $json[0] = $view->Render("manuelscolaire" . DS . "ajax" . DS . "index", false);
        }
        echo json_encode($json);
    }

    public function delete($idmanuel){
        if(!isAuth(244)){
            return;
        }
        $this->Manuelscolaire->delete($idmanuel);
        header("Location:" . Router::url("manuelscolaire"));
    }
    public function edit($id) {
        $this->view->clientsJS("manuelscolaire" . DS . "edit");
        if (!empty($this->request->idmanuel)) {
            $this->validateEdit();
        }
        $view = new View();
        $view->Assign("errors", false);
        $manuel = $this->Manuelscolaire->get($id);
        $view->Assign("manuel", $manuel);
        $content = $view->Render("manuelscolaire" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function imprimer() {
        parent::printable();
        $action = $this->request->code;
        $type = $this->request->type_impression;
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($action) {
            case "0001":
                $manuels = $this->Manuelscolaire->selectAll();
                $view->Assign("manuels", $manuels);
                if ($type == "pdf") {
                    echo $view->Render("manuelscolaire" . DS . "impression" . DS . "listemanuelscolaire", false);
                } elseif ($type == "excel") {
                    echo $view->Render("manuelscolaire" . DS . "xls" . DS . "listemanuelscolaire", false);
                }
                break;
        }
    }

}
