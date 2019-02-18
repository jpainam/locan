<?php

# 203 : Consulter les infos sur le personnel

class personnelController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("civilite");
        $this->loadModel("fonction");
        $this->loadModel("region");
        $this->loadModel("departement");
        $this->loadModel("arrondissement");
        $this->loadModel("siege");
        $this->loadModel("etablissement");
        $this->loadModel("diplome");
        $this->loadModel("categorie");
        $this->loadModel("statutpersonnel");
        $this->loadModel("specialite");
    }

    function index() {
        if (!isAuth(203)) {
            return;
        }
        $this->view->clientsJS("personnel" . DS . "index");

        $data = $this->Fonction->selectAll();
        $comboFonctions = new Combobox($data, "comboFonctions", "IDFONCTION", "LIBELLE");
        $comboFonctions->first = "Toutes";

        $view = new View();
        $personnels = $this->Personnel->selectAll();
        $view->Assign("comboFonctions", $comboFonctions->view());
        $view->Assign("personnels", $personnels);

        $listepersonnels = $view->Render("personnel" . DS . "ajax" . DS . "index", false);
        $view->Assign("listepersonnels", $listepersonnels);
        $content = $view->Render("personnel" . DS . "index", FALSE);
        $this->Assign("content", $content);
    }

    /**
     * Function ajax appellee quand on choisi une function, confere showPersonnelByFunction()
     * dans la methode index. Permet l'affichage du personnel en fonction du onchange dans la fonction
     */
    public function ajax() {
        $view = new View();
        if (!empty($this->request->fonction)) {
            $personnels = $this->Personnel->findBy(["FONCTION" => $this->request->fonction]);
        } else {
            $personnels = $this->Personnel->selectAll();
        }

        $view->Assign("personnels", $personnels);
        $json_array[0] = $view->Render("personnel" . DS . "ajax" . DS . "index", false);

        echo json_encode($json_array);
    }

    private function validerSaisie() {
        $generer = $this->request->matricule;
        $params = [
            "civilite" => $this->request->civilite,
            "nom" => $this->request->nom,
            "prenom" => $this->request->prenom,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "fonction" => $this->request->fonction,
            "grade" => $this->request->grade,
            "datenaiss" => parseDate($this->request->datenaiss),
            "telephone" => $this->request->telephone,
            "portable" => $this->request->portable,
            "email" => $this->request->email,
            "photo" => $this->request->photopersonnel,
            "arrondissement" => $this->request->arrondissement,
            "siege" => $this->request->siege,
            "structure" => $this->request->structure,
            "diplome" => $this->request->diplome,
            "categorie" => $this->request->categorie,
            "indemnitaire" => $this->request->indemnitaire,
            "solde" => $this->request->solde,
            "carriere" => $this->request->carriere,
            "nominatif" => $this->request->reftexte,
            "echelon" => $this->request->echelon,
            "statut" => $this->request->statut,
            "dmr" => $this->request->dmramr,
            "avancement" => parseDate($this->request->dateavancement)
        ];

        $this->Personnel->insert($params);
        $lastinsertid = $this->Personnel->lastInsertId();
        if (empty($this->request->matricule)) {
            $generer = strtoupper(substr($this->request->nom, 0, 6)) . $lastinsertid;
        }
        $this->Personnel->update(["matricule" => $generer], ["IDPERSONNEL" => $lastinsertid]);
        header("Location:" . url('personnel'));
    }

    /**
     * 
     * CODEDROIT : 502
     */
    public function saisie() {
        if (!isAuth(502)) {
            return;
        }
        $this->view->clientsJS("personnel" . DS . "saisie");
        $view = new View();
        $view->Assign('errors', false);
        if (!empty($this->request->nom) && !empty($this->request->fonction) && !empty($this->request->portable)) {
            $this->validerSaisie();
        }

        $data = $this->Civilite->selectAll();
        $civilite = new Combobox($data, "civilite", "CIVILITE", "CIVILITE", true, "Mr");
        $view->Assign("civilite", $civilite->view("150px"));

        $data = $this->Fonction->selectAll();
        $fonctions = new Combobox($data, "fonction", "IDFONCTION", "LIBELLE");
        $view->Assign("fonctions", $fonctions->view());

        #Region
        $region = new Combobox($this->Region->selectAll(), "region", $this->Region->getKey(), $this->Region->getLibelle());
        $region->first = " ";
        $view->Assign("region", $region->view());

        # Structure
        $ets = $this->Etablissement->selectAll();
        $view->Assign("etablissements", $ets);
        $structure = $view->Render("personnel" . DS . "ajax" . DS . "comboStructure", false);
        $view->Assign("structure", $structure);

        # Diplome
        $diplome = new Combobox($this->Diplome->selectAll(), "diplome", $this->Diplome->getKey(), $this->Diplome->getLibelle());
        $diplome->first = " ";
        $view->Assign("diplome", $diplome->view());

        # Categorie
        $categorie = new Combobox($this->Categorie->selectAll(), "categorie", $this->Categorie->getKey(), $this->Categorie->getLibelle());
        $categorie->first = " ";
        $view->Assign("categorie", $categorie->view());

        # Statut
        $statut = new Combobox($this->Statutpersonnel->selectAll(), "statut", $this->Statutpersonnel->getKey(), $this->Statutpersonnel->getLibelle());
        $statut->first = " ";
        $view->Assign("statut", $statut->view());

        $content = $view->Render("personnel" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "chargerDepartement":
                if (!empty($this->request->preciserdept)) {
                    $params = ["libelle" => $this->request->preciserdept,
                        "region" => $this->request->region];
                    $this->Departement->insert($params);
                    $lastinsert = $this->Departement->lastInsertId();
                    $view->Assign("lastinsert", $lastinsert);
                }
                $departement = $this->Departement->findBy(["REGION" => $this->request->region]);
                $view->Assign("departements", $departement);
                $json[0] = $view->Render("personnel" . DS . "ajax" . DS . "comboDepartement", false);
                break;
            case "chargerArrondissement":
                if (!empty($this->request->preciserarr)) {
                    $params = ["libelle" => $this->request->preciserarr,
                        "departement" => $this->request->departement];
                    $this->Arrondissement->insert($params);
                    $lastinsert = $this->Arrondissement->lastInsertId();
                    $view->Assign("lastinsert", $lastinsert);
                }
                $arrondissement = $this->Arrondissement->findBy(["DEPARTEMENT" => $this->request->departement]);
                $view->Assign("arrondissements", $arrondissement);
                $json[0] = $view->Render("personnel" . DS . "ajax" . DS . "comboArrondissement", false);
                break;
            case "preciserets":
                $this->Etablissement->insert(["etablissement" => $this->request->preciserets]);
                $lastinsert = $this->Etablissement->lastInsertId();
                $view->Assign("lastinsert", $lastinsert);
                $ets = $this->Etablissement->selectAll();
                $view->Assign("etablissements", $ets);
                $json[0] = $view->Render("personnel" . DS . "ajax" . DS . "comboStructure", false);
                break;
        }
        echo json_encode($json);
    }

    /**
     * CODEDROIT : 507
     * @param int $id
     */
    public function delete($id) {
        if (!isAuth(507)) {
            return;
        }

        $val = $this->Personnel->delete($id);

        header("Location:" . Router::url('personnel'));
    }

    private function validerEdit() {
        $params = [
            "matricule" => $this->request->matricule,
            "civilite" => $this->request->civilite,
            "nom" => $this->request->nom,
            "prenom" => $this->request->prenom,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "fonction" => $this->request->fonction,
            "grade" => $this->request->grade,
            "datenaiss" => parseDate($this->request->datenaiss),
            "telephone" => $this->request->telephone,
            "portable" => $this->request->portable,
            "email" => $this->request->email,
            "photo" => $this->request->photopersonnel,
            "arrondissement" => $this->request->arrondissement,
            "siege" => $this->request->siege,
            "structure" => $this->request->structure,
            "diplome" => $this->request->diplome,
            "categorie" => $this->request->categorie,
            "indemnitaire" => $this->request->indemnitaire,
            "solde" => $this->request->solde,
            "carriere" => $this->request->carriere,
            "nominatif" => $this->request->reftexte,
            "echelon" => $this->request->echelon,
            "statut" => $this->request->statut,
            "dmr" => $this->request->dmramr,
            "avancement" => parseDate($this->request->dateavancement)
        ];
        $this->Personnel->update($params, ["IDPERSONNEL" => $this->request->idpersonnel]);
        header("Location:" . Router::url("personnel"));
    }

    public function edit($id) {
        if (!empty($this->request->idpersonnel)) {
            $this->validerEdit();
        }
        
        $this->view->clientsJS("personnel" . DS . "edit");
        $view = new View();
        $personnel = $this->Personnel->get($id);
        //var_dump($personnel);
        $view->Assign("personnel", $personnel);

       $data = $this->Civilite->selectAll();
        $civilite = new Combobox($data, "civilite", "CIVILITE", "CIVILITE", true, $personnel['CIVILITE']);
        $view->Assign("civilite", $civilite->view());

        $data = $this->Fonction->selectAll();
        $fonctions = new Combobox($data, "fonction", "IDFONCTION", "LIBELLE", true, $personnel['FONCTION']);
        $view->Assign("fonctions", $fonctions->view());

        #Region
        $data = $this->Region->selectAll();
        $region = new Combobox($data, "region", $this->Region->getKey(), $this->Region->getLibelle(), 
                true, isset($personnel['REGION']) ? $personnel['REGION'] : null);
        $region->first = " ";
        $view->Assign("region", $region->view());
        
        #Departement
        $data = $this->Departement->selectAll();
        $view->Assign("lastinsert", $personnel['DEPARTEMENT']);
        $view->Assign("departements", $data);
        $departement = $view->Render("personnel" . DS . "ajax" . DS . "comboDepartement", false);
        $view->Assign("departement", $departement);
        
        #Arrondissement
        $data = $this->Arrondissement->selectAll();
        $view->Assign("lastinsert", $personnel['ARRONDISSEMENT']);
        $view->Assign("arrondissements", $data);
        $arrondissement = $view->Render("personnel" . DS . "ajax" . DS . "comboArrondissement", false);
        $view->Assign("arrondissement", $arrondissement);

        # Structure
        $ets = $this->Etablissement->selectAll();
        $view->Assign("lastinsert", $personnel['STRUCTURE']);
        $view->Assign("etablissements", $ets);
        $structure = $view->Render("personnel" . DS . "ajax" . DS . "comboStructure", false);
        $view->Assign("structure", $structure);

        # Diplome
        $data = $this->Diplome->selectAll();
        $diplome = new Combobox($data, "diplome", $this->Diplome->getKey(), $this->Diplome->getLibelle(), 
                true, isset($personnel['DIPLOME']) ? $personnel['DIPLOME'] : null);
        $diplome->first = " ";
        $view->Assign("diplome", $diplome->view());

        # Categorie
        $data = $this->Categorie->selectAll();
        $categorie = new Combobox($data, "categorie", $this->Categorie->getKey(), $this->Categorie->getLibelle(), 
                true, isset($personnel['CATEGORIE']) ? $personnel['CATEGORIE'] : null);
        $categorie->first = " ";
        $view->Assign("categorie", $categorie->view());

        # Statut
        $data = $this->Statutpersonnel->selectAll();
        $statut = new Combobox($data, "statut", $this->Statutpersonnel->getKey(), $this->Statutpersonnel->getLibelle(), 
                true, isset($personnel['STATUT']) ? $personnel['STATUT'] : null);
        $statut->first = " ";
        $view->Assign("statut", $statut->view());

        $content = $view->Render("personnel" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function discipline() {
        $this->view->clientsJS("personnel" . DS . "discipline");
        $view = new View();
        $content = $view->Render("personnel" . DS . "discipline", false);
        $this->Assign("content", $content);
    }

    # Utiliser dans la page saisie eleve et permet
    # d'uploader la photo sur le server et concerver 
    # le chemin dans un input hidden qui sera ensuite envoyer par le formulaire generale de l'eleve
    # 0 pour premiere submission dont l'aaction est ajout
    # 1 pour seconde soumission dont l'action est effacer

    public function photo($action) {
        $json_array = array();
        if (!strcmp($action, "upload")) {
            $photo = "";
            $message = "";
            if (move_uploaded_file($_FILES['photo']['tmp_name'], ROOT . "/public/photos/personnels/" . $_FILES['photo']['name'])) {
                $photo = SITE_ROOT . "public/photos/personnels/" . $_FILES['photo']['name'];
            } else {
                $message = "Erreur lors de la sauvegarde du fichier photo : " . $_FILES['photo']['name'];
            }

            if (!empty($photo)) {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoPersonnel();");
            } else {
                $json_array[0] = btn_add("savePhotoPersonnel();") . " " . btn_effacer_disabled("");
            }
            $json_array[1] = $photo;
            $json_array[2] = $message;
            $json_array[3] = $_FILES['photo']['name'];
        } else {
            if (file_exists(ROOT . DS . "public" . DS . "photos" . DS . "personnels" . DS . $action)) {
                unlink(ROOT . DS . "public" . DS . "photos" . DS . "personnels" . DS . $action);
                $json_array[0] = btn_add("savePhotoPersonnel();") . " " . btn_effacer_disabled("");
                $json_array[1] = "";
                $json_array[2] = "";
                $json_array[3] = "";
            } else {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoPersonnel();");
                $json_array[1] = $action;
                $json_array[2] = "Erreur lors de la suppression de l'image";
                $json_array[3] = "";
            }
        }
        print json_encode($json_array);
    }

    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            # 0001 Impression de la fiche du pesonnel
            case "0001":
                $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" =>
                    $this->request->idpersonnel]);
                $view->Assign("personnel", $personnel);
                echo $view->Render("personnel" . DS . "impression" . DS . "fiche", false);
                break;
            case "0002":
                echo $view->Render("personnel" . DS . "impression" . DS . "syntheseadministratif", false);
                break;
        }
    }

}
