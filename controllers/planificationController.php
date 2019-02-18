<?php

class planificationController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $this->loadModel("sequence");
        $this->loadModel("matiere");
        $classe = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classe, "comboClasses", $this->Classe->getKey(), "NIVEAUSELECT");
    }

    public function index() {
        
    }

    public function saisie() {
        $this->view->clientsJS("planification" . DS . "saisie");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        # Sequences
        $periode = $this->Sequence->getSequences($this->session->anneeacademique);
        $comboSequences = new Combobox($periode, "comboSequences", $this->Sequence->getKey(), $this->Sequence->getLibelle());
        $comboSequences->first = " ";
        $view->Assign("comboSequences", $comboSequences->view());
        $content = $view->Render("planification" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie() {
        $view = new View();
        $json = array();
        $json[0] = "";
        $action = $this->request->action;
        switch ($action) {
            case "chargerEnseignement":
                $enseignement = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignement);
                $json[1] = $view->Render("planification" . DS . "ajax" . DS . "comboEnseignement", false);
                break;
            case "supprimerPlanification":
                $this->Planification->delete($this->request->idplanification);
                break;
            case "ajouterPlanification":
                $params = ["enseignement" => $this->request->idenseignement,
                    "nbheure" => $this->request->nbheure,
                    "sequence" => $this->request->idsequence];
                $this->Planification->insert($params);
                break;
        }
        # Charger la planification
        if ($action === "filtrerPlanification") {
            $planifications = $this->Planification->findBy(["enseignement" => $this->request->idenseignement]);
        } else {
            $planifications = $this->Planification->getPlanificationsByClasse($this->request->idclasse);
        }
        $view->Assign("planifications", $planifications);
        $json[0] = $view->Render("planification" . DS . "ajax" . DS . "planification", false);

        echo json_encode($json);
    }

    public function imprimer() {
        parent::printable();

        $view = new View();
        $view->Assign("pdf", $this->pdf);
        $action = $this->request->code;

        switch ($action) {
            # Impression de la grille horaire, repartition horaire par matiere
            case "0001":
                $planifications = $this->Planification->selectAll();
                $view->Assign("planifications", $planifications);
                
                $matieres = $this->Matiere->selectAll();
                $view->Assign("matieres", $matieres);
                
                $classes = $this->Classe->selectAll();
                $view->Assign("classes", $classes);
                echo $view->Render("planification" . DS . "impression" . DS . "grillehoraire", false);
                break;
        }
    }

}
