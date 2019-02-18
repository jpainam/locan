<?php

class emploisController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("enseignement");
        $this->loadModel("horaire");
        $data = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($data, "comboClasses", $this->Classe->getKey(), $this->Classe->getLibelle());
    }

    public function index() {
        
    }

    public function saisie() {
        $this->view->clientsJS("emplois" . DS . "emplois");

        $view = new View();

        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $horaires = $this->Horaire->findBy(["PERIODE" => $this->session->anneeacademique]);
        $view->Assign("horaires", $horaires);
        $content = $view->Render("emplois" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie($action) {
        $json = array();
        $json[0] = "";
        $view = new View();
        $horaire = $this->Horaire->selectAll();
        $heure_debut = array();
        foreach ($horaire as $line){
            $heure_debut[] = substr($line["HEUREDEBUT"], 0, strlen($line["HEUREDEBUT"]) - 3);
        }
        $view->Assign("horaire", $horaire);
        $view->Assign("heure_debut", json_encode($heure_debut));

        switch ($action) {
            case "charger":
                $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("emplois" . DS . "ajax" . DS . "enseignement", FALSE);
                break;
            case "ajout":
                $horaires = $this->Horaire->getHoraireIntervalle($this->request->horairedebut, $this->request->horairefin, $this->session->anneeacademique);

                foreach ($horaires as $h) {
                    $params = ["jour" => $this->request->jour,
                        "enseignement" => $this->request->enseignement,
                        "horaire" => $h['IDHORAIRE']];

                    # Inserer dans la BD 
                    $this->Emplois->insert($params);
                }
                if (empty($this->request->horairefin)) {
                    $params = ["jour" => $this->request->jour,
                        "enseignement" => $this->request->enseignement,
                        "horaire" => $this->request->horairedebut];

                    # Inserer dans la BD 
                    $this->Emplois->insert($params);
                }
                break;
            case "supprimer":
                $this->Emplois->delete($this->request->idemplois);
                break;
        }
        //dataTable de l'emploi du temps: Onglet 1
        $ens = $this->Emplois->getEmplois($this->request->idclasse);
        $view->Assign("enseignements", $ens);
        $json[1] = $view->Render("emplois" . DS . "ajax" . DS . "emplois", false);
        //apercu de l'emploi du temps: Onglet 2
        $json[2] = $view->Render("emplois" . DS . "ajax" . DS . "apercu", false);
        echo json_encode($json);
    }

}
