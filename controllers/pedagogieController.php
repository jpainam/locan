<?php

class pedagogieController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $this->loadModel("chapitre");
        $this->loadModel("sequence");
        $this->loadModel("lecon");
        $this->loadModel("programmation");
        $this->loadModel("personnel");

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), ['LIBELLE', 'NIVEAUSELECT']);
    }

    public function index() {
        $this->view->clientsJS("pedagogie" . DS . "index");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $content = $view->Render("pedagogie" . DS . "index", false);
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
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "chargerChapitre":
                $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
                $view->Assign("chapitres", $chapitres);
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "index", false);
                break;
        }
        echo json_encode($json);
    }

    public function saisie() {
        $view = new View();
        $content = $view->Render("pedagogie" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function programmation() {
        if (!empty($this->request->programmation)) {
            $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
            foreach ($chapitres as $chap) {
                $seq = $this->request->{"seq" . $chap['IDCHAPITRE']};
                $params = ["sequence" => $seq];
                $this->Chapitre->update($params, ["IDCHAPITRE" => $chap['IDCHAPITRE']]);
            }
            # Inserer les lecon dans la table programmation
            # Supprimer les ancienne programmation par enseignement
            $this->Programmation->deleteProgrammationsByEnseignement($this->request->idenseignement);
            $lecons = $this->Lecon->getLeconsByEnseignement($this->request->idenseignement);
            foreach ($lecons as $lec) {
                $params = ["lecon" => $lec['IDLECON'],
                    "etat" => 0];
                $this->Programmation->insert($params);
            }
            header("Location:" . Router::url("pedagogie"));
        }
        $this->view->clientsJS("pedagogie" . DS . "programmation");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $content = $view->Render("pedagogie" . DS . "programmation", false);
        $this->Assign("content", $content);
    }

    public function ajaxprogrammation() {
        $view = new View();
        $action = $this->request->action;
        $json = array();
        switch ($action) {
            case "chargerEnseignement":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "chargerProgrammation":
                $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
                $view->Assign("chapitres", $chapitres);
                $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
                $view->Assign("sequences", $sequences);
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "programmation", false);

                break;
        }
        echo json_encode($json);
    }

    public function suivi() {
        if (!empty($this->request->suivi)) {
            $programmation = $this->Programmation->getProgrammationsByEnseignement($this->request->idenseignement);
            $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);

            foreach ($programmation as $prog) {
                $etat = $this->request->{"prog" . $prog['IDPROGRAMMATION']};
                $params = ["etat" => $etat,
                    "datefait" => date("Y-m-d", time()),
                    "faitpar" => $personnel['IDPERSONNEL']];
                $this->Programmation->update($params, ["IDPROGRAMMATION" => $prog['IDPROGRAMMATION']]);
            }
        }
        $this->view->clientsJS("pedagogie" . DS . "suivi");

        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $content = $view->Render("pedagogie" . DS . "suivi", false);
        $this->Assign("content", $content);
    }

    public function ajaxsuivi() {
        $view = new View();
        $action = $this->request->action;
        $json = array();
        switch ($action) {
            case "chargerEnseignement":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "chargerProgrammation":
                $programmation = $this->Programmation->getProgrammationsByEnseignement($this->request->idenseignement);
                $view->Assign("programmation", $programmation);
                $json[0] = $view->Render("pedagogie" . DS . "ajax" . DS . "suivi1", false);

                # Si toutes les lecons de ce chapitre sont, alors afficher a cote fait
                $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
                $view->Assign("chapitres", $chapitres);
                $json[1] = $view->Render("pedagogie" . DS . "ajax" . DS . "suivi2", false);
                break;
        }
        echo json_encode($json);
    }

    public function imprimer() {
        parent::printable();
        $code = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($code) {
            # Impression de la programmation pedagogique 
            case "0001":
                $enseignement = $this->Enseignement->get($this->request->idenseignement);
                $view->Assign("enseignement", $enseignement);
                $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
                $view->Assign("chapitres", $chapitres);
                echo $view->Render("pedagogie" . DS . "impression" . DS . "programmationpedagogique", false);
                break;
            
             # impression du suivi pedagogique
            case "0002":
                # Si toutes les lecons de ce chapitre sont, alors afficher a cote fait
                $chapitres = $this->Chapitre->getChapitresByEnseignement($this->request->idenseignement);
                $view->Assign("chapitres", $chapitres);
                echo $view->Render("pedagogie" . DS . "impression" . DS . "suivipedagogique", false);
                break;
        }
    }

}
