<?php

/**
 * Droit pour saisir les activites
 */
class activiteController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $this->loadModel("chapitre");
        $this->loadModel("lecon");

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), ['LIBELLE', 'NIVEAUSELECT']);
    }

    public function index() {
        $this->view->clientsJS("activite" . DS . "index");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $content = $view->Render("activite" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function ajaxindex() {
        $view = new View();
        $action = $this->request->action;
        $json = array();
        switch ($action) {
            case "chargerEnseignement":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("activite" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "chargerActivite":
                $activites = $this->Activite->findBy(["ENSEIGNEMENT" => $this->request->idenseignement]);
                $view->Assign("activites", $activites);
                $json[0] = $view->Render("activite" . DS . "ajax" . DS . "chargerActivite", false);
                break;
            case "chargerChapitre":
                $lecons = $this->Lecon->getLeconsByActivite($this->request->idactivite);
                $view->Assign("lecons", $lecons);
                $json[0] = $view->Render("activite" . DS . "ajax" . DS . "chargerChapitre", false);
                break;
        }
        echo json_encode($json);
    }

    public function saisie() {
        if (!isAuth(523)) {
            return;
        }
        $this->view->clientsJS("activite" . DS . "saisie");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $content = $view->Render("activite" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie() {
        $action = $this->request->action;
        $view = new View();
        $json = array();

        switch ($action) {
            case "chargerEnseignement":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("activite" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "ajouterActivite":
                $params = ["titre" => $this->request->description,
                    "enseignement" => $this->request->idenseignement];
                $this->Activite->insert($params);
                break;

            case "supprimerActivite":
                $this->Activite->delete($this->request->idactivite);
                break;
            case "supprimerChapitre":
                $this->Chapitre->delete($this->request->idchapitre);
                break;
            case "supprimerLecon":
                $this->Lecon->delete($this->request->idlecon);
                break;
            case "ajouterChapitre":
                $params = ["activite" => $this->request->idactivite,
                    "titre" => $this->request->description];
                $this->Chapitre->insert($params);
                break;
            case "ajouterLecon":
                $params = ["chapitre" => $this->request->idchapitre,
                    "titre" => $this->request->description];
                $this->Lecon->insert($params);
                break;
            case "editerActivite":
                $params = ["titre" => $this->request->description];
                $this->Activite->update($params, ["IDACTIVITE" => $this->request->idactivite]);
                break;
            case "editerChapitre":
                $params = ["titre" => $this->request->description];
                $this->Chapitre->update($params, ["IDCHAPITRE" => $this->request->idchapitre]);
                break;
        }
        if ($action == "ajouterActivite" || $action == "chargerActivite" || $action == "supprimerActivite" ||
                $action == "editerActivite") {
            $activites = $this->Activite->findBy(["ENSEIGNEMENT" => $this->request->idenseignement]);
            $view->Assign("activites", $activites);
            $json[0] = $view->Render("activite" . DS . "ajax" . DS . "tableActivite", false);
        }
        if ($action == "chargerChapitre" || $action == "ajouterChapitre" || $action == "supprimerChapitre" ||
                $action == "editerChapitre") {
            $chapitres = $this->Chapitre->findBy(["ACTIVITE" => $this->request->idactivite]);
            $view->Assign("chapitres", $chapitres);
            $activite = $this->Activite->get($this->request->idactivite);
            $view->Assign("activite", $activite);
            $json[0] = $view->Render("activite" . DS . "ajax" . DS . "tableChapitre", false);
        }
        if ($action == "chargerLecon" || $action == "ajouterLecon" || $action == "supprimerLecon") {
            $lecons = $this->Lecon->findBy(["CHAPITRE" => $this->request->idchapitre]);
            $view->Assign("lecons", $lecons);
            $chapitre = $this->Chapitre->get($this->request->idchapitre);
            $view->Assign("chapitre", $chapitre);
            $json[0] = $view->Render("activite" . DS . "ajax" . DS . "tableLecon", false);
        }
        echo json_encode($json);
    }

    public function imprimer(){
        parent::printable();
        $code = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($code){
            # Impression des activites pedagogiques dans activite/index
            case "0001":
                echo $view->Render("activite" . DS . "impression" . DS . "activitepedagogique", false);
                break;
        }
    }
}
