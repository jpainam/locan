<?php

class etablissementController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("locan");
        $this->loadModel("personnel");
        $this->loadModel("eleve");
        $this->loadModel("eleveexclus");
    }

    public function index() {
        if (!isAuth(201)) {
            return;
        }
        $this->view->clientsJS("etablissement" . DS . "index");
        $view = new View();


        $ets = $this->Locan->selectAll()[0];
        $view->Assign("ets", $ets['NOM']);
        $view->Assign("responsable", $ets['RESPONSABLE']);
        $view->Assign("adresse", $ets['ADRESSE']);
        $view->Assign("tel1", $ets['TELEPHONE']);
        $view->Assign("tel2", $ets['TELEPHONE2']);
        $view->Assign("mobile", $ets['MOBILE']);
        $view->Assign("email", $ets['EMAIL']);


        $data = $this->Personnel->selectAll();
        $personnels = new Grid($data, 2);
        $personnels->dataTable = "persoTable";
        $personnels->addcolonne(1, "Civ", "CIVILITE");
        $personnels->addcolonne(2, "Matricule", "IDPERSONNEL", false);
        $personnels->addcolonne(3, "Nom", "NOM");
        $personnels->addcolonne(4, "Prénom", "PRENOM");
        $personnels->addcolonne(5, "Fonction", "LIBELLE");
        $personnels->addcolonne(6, "Téléphone", "TELEPHONE");
        $personnels->actionbutton = false;
        $view->Assign("personnels", $personnels->display());


        $data = $this->Eleve->selectAllInscrit();

        $eleves = new Grid($data, 0);
        $eleves->dataTable = "eleveTable";
        $eleves->addcolonne(0, "IDELEVE", "IDELEVE", false);
        $eleves->addcolonne(1, "Matricule", "MATRICULE");
        $eleves->addcolonne(2, "Nom", "NOM");
        $eleves->addcolonne(3, "Prenom", "PRENOM");
        $eleves->addcolonne(4, "Sexe", "SEXE");
        $eleves->addcolonne(5, "Classe", "NIVEAUHTML");
        $eleves->addcolonne(6, "Naissance", "DATENAISS");
        $eleves->actionbutton = false;
        $eleves->setColDate(6);
        $view->Assign("eleves", $eleves->display());

        $data = $this->Etablissement->getNouveauEleves();
        $nouveau = new Grid($data, 0);
        $nouveau->dataTable = "dataTable";
        $nouveau->addcolonne(0, "IDELEVE", "IDELEVE", false);
        $nouveau->addcolonne(1, "Matricule", "MATRICULE");
        $nouveau->addcolonne(2, "Noms et Prenoms", "CNOM");
        $nouveau->addcolonne(3, "Sexe", "SEXE");
        $nouveau->addcolonne(4, "Classe", "NIVEAUHTML");
        $nouveau->addcolonne(5, "Naissance", "DATENAISS");
        $nouveau->addcolonne(6, "Redoublant", "REDOUBLANTLBL");
        $nouveau->actionbutton = false;
        $nouveau->setColDate(5);
        $view->Assign("nouveaueleves", $nouveau->display());

        $elevesexclus = $this->Eleveexclus->findBy(["PERIODE" => $_SESSION['anneeacademique']]);
        $view->Assign("eleveexclus", $elevesexclus);
        $content = $view->Render("etablissement" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function saisie() {
        $view = new View();
        if (!isAuth(501)) {
            return;
        }
        if (!empty($this->request->nouvelets)) {
            $params = ["etablissement" => $this->request->nouvelets];
            $this->Etablissement->insert($params);
            header("Location:" . Router::url("etablissement", "saisie"));
        }
        $this->view->clientsJS("etablissement" . DS . "saisie");
        if (empty($this->request->addnewets)) {
            $ets = $this->Etablissement->selectAll();
            $view->Assign("etablissements", $ets);
            $content = $view->Render("etablissement" . DS . "showEtablissement", false);
        } else {
            $content = $view->Render("etablissement" . DS . "saisie", false);
        }
        $this->Assign("content", $content);
    }

    public function delete($id) {
        $this->Etablissement->delete($id);
        header("Location:" . Router::url("etablissement", "saisie"));
    }

    public function ajaxsaisie() {
        $action = $this->request->action;
        $json = array();
        $view = new View();
        switch ($action) {
            case "editEtablissement":
                $this->Etablissement->update(["ETABLISSEMENT" => $this->request->libelle], ["IDETABLISSEMENT" => $this->request->idets]);
                $ets = $this->Etablissement->selectAll();
                $view->Assign("etablissements", $ets);
                $json[0] = $view->Render("etablissement" . DS . "ajax" . DS . "showEtablissement", false);
                break;
            # Preciser etablissement dans eleve/saisie
            case "preciserEts":
                $params = ["etablissement" => $this->request->preciserets];
                $this->Etablissement->insert($params);
                $lastinsert = $this->Etablissement->lastInsertId();
                $view->Assign("lastinsert", $lastinsert);
                $etablissements = $this->Etablissement->selectAll();
                $view->Assign("etablissements", $etablissements);
                $json[0] = $view->Render("eleve" . DS . "ajax" . DS . "comboProvenance", false);
                break;
        }
        echo json_encode($json);
    }

    public function imprimer() {
        parent::printable();
        $action = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        if($action !== "0008"){
            $eleves = $this->Eleve->selectAllInscrit();
        }else{
            $eleves = $this->Etablissement->getNouveauEleves();
        }
        $view->Assign("eleves", $eleves);
        $personnels = $this->Personnel->selectAll();
        $view->Assign("personnels", $personnels);

        switch ($action) {
            case "0001":
                echo $view->Render("etablissement" . DS . "impression" . DS . "info", false);
                break;
            case "0002":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listesimpleeleves", false);
                break;
            case "0003":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listedetailleeleves", false);
                break;
            case "0004":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listesimplepersonnels", false);
                break;
            case "0005":
                echo $view->Render("etablissement" . DS . "impression" . DS . "listedetaillepersonnels", false);
                break;
            # Impression du planning pedagogique
            case "0006":
                echo $view->Render("etablissement" . DS . "impression" . DS . "planningpedagogique", false);
                break;
            # Impression du planning pedagogique
            case "0007":
                echo $view->Render("etablissement" . DS . "impression" . DS . "chefdeclasse", false);
                break;
            
             case "0008":
                echo $view->Render("etablissement" . DS . "impression" . DS . "nouveaueleve", false);
                break;
            case "0009":
                $view->Assign("anneescolaire", $_SESSION['anneeacademique']);
                echo $view->Render("etablissement" . DS . "impression" . DS . "fichedemandeinscription",
                        false);
                break;
        }
    }

}
