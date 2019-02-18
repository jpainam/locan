<?php

class punitionController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("anneeacademique");
        $this->loadModel("typepunition");
        $this->loadModel("personnel");
        $this->loadModel("inscription");

        $data = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($data, "comboClasses", $this->Classe->getKey(), 
		["LIBELLE", "NIVEAUSELECT"]);
        $this->comboClasses->first = " ";
    }

    public function index() {
        if (!isAuth(311)) {
            return;
        }
        $this->view->clientsJS("punition" . DS . "index");
        $view = new View();
        $punitions = $this->Punition->selectAll();

        $view->Assign("punitions", $punitions);
        $anneeAcademique = $this->Anneeacademique->selectAll();
        $comboAnneeAcademique = new Combobox($anneeAcademique, "comboAnneeAcademique", $this->Anneeacademique->getKey(), $this->Anneeacademique->getLibelle());
        $comboAnneeAcademique->first = " ";

        $view->Assign("comboAnneeAcademique", $comboAnneeAcademique->view());
        $this->comboClasses->first = "Toutes";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $view->Assign("punitionTable", $view->Render("punition" . DS . "ajax" . DS . "punition", false));
        $content = $view->Render("punition" . DS . "index", false);
        $this->Assign("content", $content);
    }

    /**
     * Droit saisie punition: 315
     */
    public function saisie() {
        if (!isAuth(315)) {
            return;
        }
        if (!empty($this->request->punipar)) {
            $params = ["eleve" => $this->request->comboEleves,
                "datepunition" => $this->request->datepunition,
                "dateenregistrement" => date("Y-m-d", time()),
                "duree" => $this->request->duree,
                "typepunition" => $this->request->comboTypes,
                "motif" => $this->request->motif,
                "description" => $this->request->description,
                "punipar" => $this->request->punipar,
                "enregistrerpar" => $this->session->user,
                "anneeacademique" => $this->session->anneeacademique];
            $this->Punition->insert($params);
            header("Location:" . Router::url("punition"));
        }
        $this->view->clientsJS("punition" . DS . "punition");
        $view = new View();

        $type = $this->Typepunition->selectAll();
        $comboTypes = new Combobox($type, "comboTypes", $this->Typepunition->getKey(), $this->Typepunition->getLibelle());
        $comboTypes->first = " ";
        $view->Assign("comboTypes", $comboTypes->view());
        $view->Assign("comboClasses", $this->comboClasses->view());

        $personnels = $this->Personnel->selectAll();
        $comboPersonnels = new Combobox($personnels, "comboPersonnels", $this->Personnel->getKey(), $this->Personnel->getLibelle());
        $comboPersonnels->first = " ";
        $view->Assign("comboPersonnels", $comboPersonnels->view());

        $content = $view->Render("punition" . DS . "saisie", false);
        $this->Assign("content", $content);
        //$this->Assign("content", (new View())->output());
    }

    public function ajax($action) {
        $json = array();
        $view = new View();
        switch ($action) {
            case "charger":
                $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                $view->Assign("eleves", $eleves);
                $json[0] = $view->Render("punition" . DS . "ajax" . DS . "comboEleves", false);
                break;
        }
        echo json_encode($json);
    }

    public function delete($idpunition) {
        $this->Punition->delete($idpunition);
        header("Location:" . Router::url("punition"));
    }

    public function imprimer($id = "") {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        //Si id est vide, alors imprimer tous les les punitions de cette annee academique
        if(empty($id)){
            $punition = $this->Punition->findBy(["ANNEEACADEMIQUE" => $this->session->anneeacademique]);
        }
        //Sinon, imprimer la punition specifique a cet eleve
        else{
            $punition = $this->Punition->get($id);
        }
        $view->Assign("punition", $punition);
        echo $view->Render("punition" . DS . "imprimer", false);
    }

}
