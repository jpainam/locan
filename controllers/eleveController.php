<?php

/**
 * PAGES AJAX : 800XX
 * 520 : modification des eleve
 * 521 : suppression des eleves
 */
class EleveController extends Controller {

    private $comboCivilite;
    private $comboParente;

    public function __construct() {
        parent::__construct();
        /**
         * Chargement des libraries utilisees dans cette classes
         */
        $this->loadModel("pays");
        $this->loadModel('etablissement');
        $this->loadModel("civilite");
        $this->loadModel("responsable");
        $this->loadModel("charge");
        $this->loadModel("parente");
        $this->loadModel("motifsortie");
        $this->loadModel("responsableeleve");
        $this->loadModel("responsableEleve");
        $this->loadModel("anneeacademique");
        $this->loadModel("classe");
        $this->loadModel("absence");
        $this->loadModel("messagetype");
        $this->loadModel("emplois");
        $this->loadModel("horaire");
        $this->loadModel("compteeleve");
        $this->loadModel("personnel");
        $this->loadModel("caisse");
        $this->loadModel("inscription");
        $this->loadModel("note");
        $this->loadModel("notation");

        $civ = $this->Civilite->selectAll();
        $this->comboCivilite = new Combobox($civ, "civilite", "CIVILITE", "CIVILITE");
        $this->comboCivilite->selectedid = "Mr";

        $par = $this->Parente->selectAll();
        $this->comboParente = new Combobox($par, "parente", "LIBELLE", "LIBELLE");
    }

    public function index() {
        if (!isAuth(204)) {
            return;
        }
        $view = new View();
        $this->view->clientsJS("eleve" . DS . "index");
        //Le model du dit controller est charger automatiquement
        //$this->Load_Model("eleve");

        $data = $this->Eleve->selectAll();
        $eleves = new Combobox($data, "listeeleve", "IDELEVE", "CNOM");
        $eleves->onchange = "chargerEleve()";
        $eleves->idname = "listeeleve";
        $eleves->first = " ";
        $view->Assign("eleves", $eleves->view());
        if (!empty($this->request->ideleve)) {
            $view->Assign("ideleve", $this->request->ideleve);
        }
        $content = $view->Render("eleve" . DS . "index", false);
        $this->Assign("content", $content);
    }

    private function showEleves() {
        $this->view->clientsJS("eleve" . DS . "showEleves");
        $eleves = $this->Eleve->selectAll();
        $view = new View();
        $view->Assign("eleves", $eleves);
        $view->Assign("errors", false);
        $view->Assign("total", count($eleves));
        $content = $view->Render("eleve" . DS . "showEleves", false);
        $this->Assign("content", $content);
    }

    public function lazyload() {
        $eleves = $this->Eleve->selectAll();
        $view = new View();
        $view->Assign("eleves", $eleves);
        $view->Assign("errors", false);
        $view->Assign("total", count($eleves));
        echo $view->Render("eleve" . DS . "ajax" . DS . "showEleves", false);
    }

    /**
     * Methode appellee dans la validation du formulaire validateSaisie
     * Fonction deleguer de la function validate saisie
     * cette fonction gere le volet sauvegarde des informations  concernant les responsables
     * @param type $responsables des responsables sous formes d'un object JSON, ces responsables sont a inserer dans la BD
     * @param type $ideleve l'eleve dont ils sont les responsables
     */
    private function saveResponsables($resp, $ideleve = 0) {
        $this->loadModel("responsable");
        $this->loadModel("responsableeleve");
        $params = [
            "civilite" => $resp->civilite,
            "nom" => $resp->nom,
            "prenom" => $resp->prenom,
            "adresse" => $resp->adresse,
            "telephone" => $resp->telephone,
            "portable" => $resp->portable,
            "email" => $resp->email,
            "profession" => $resp->profession,
            "bp" => $resp->bp,
            "acceptesms" => isset($resp->acceptesms) ? 1 : 0,
            "numsms" => $resp->numsms
        ];
        if ($this->Responsable->insert($params)) {
            $params = [
                "idresponsable" => $this->Responsable->lastInsertId(),
                "ideleve" => $ideleve,
                "parente" => $resp->parente,
                "charges" => json_encode($resp->charge)
            ];
            $this->Responsableeleve->insert($params);
        }
    }

    private function validerSaisie() {
        $redoublant = (strcasecmp($this->request->redoublant, "Oui") == 0);
        $provenance = empty($this->request->provenance) ? ETS_ORIGINE : $this->request->provenance;
        $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);

        $params = ["matricule" => $this->request->matricule,
            "nom" => $this->request->nomel,
            "prenom" => $this->request->prenomel,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "residence" => $this->request->residence,
            "photo" => $this->request->photoeleve,
            "cni" => $this->request->cni,
            "nationalite" => $this->request->nationalite,
            "datenaiss" => parseDate($this->request->datenaiss),
            "lieunaiss" => $this->request->lieunaiss,
            "paysnaiss" => $this->request->paysnaiss,
            "dateentree" => parseDate($this->request->dateentree),
            "provenance" => $provenance,
            "redoublant" => $redoublant,
            "enregistrerpar" => $personnel['IDPERSONNEL'],
            "freresoeur" => $this->request->frereetsoeur
        ];
        $ideleve = "";
        if (!empty($this->request->ideleve)) {
            $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
            $ideleve = $this->request->ideleve;
            # Envoyer un message de felicitation aux reponsable si une saisie de responsable avai deja ete faire
            # Si un responsable avait deja ete saisie, alors request->ideleve est non vide
            $this->activateSMS();
            $this->notifyParents($this->request->ideleve, "0002");
        } else {
            $this->Eleve->insert($params);
            $ideleve = $this->Eleve->lastInsertId();
        }
        # Verifier si l'eleve possede deja un compte caisse et inserer s'il ne le possede pas
        $compte = $this->Compteeleve->getBy(["ELEVE" => $ideleve]);
        if (empty($compte)) {

            $code = genererCodeCompte($ideleve, $this->request->nomel, $this->request->prenomel);

            $params = ["code" => $code,
                "eleve" => $ideleve,
                "creerpar" => $personnel['IDPERSONNEL'],
                "datecreation" => date("Y-m-d H:i:s", time())
            ];

            $this->Compteeleve->insert($params);
        }
        # Inscrire cette eleve dans cette classe si le champ classe n'est pas vide
        if (!empty(trim($this->request->classes))) {
            $this->inscrire($ideleve, $this->request->classes);
            $this->updateMatricule($ideleve, $this->request->classes);

            header("Location:" . Router::url("eleve", "saisie"));
        } else {
            header("Location:" . Router::url("eleve"));
        }
    }

    public function saisie() {
        # S'il n'est pas autoriser a saisir et afficher les informations
        if (!isAuth(503) && !isAuth(204)) {
            return;
        }
        if (!isAuth(503) && isAuth(204)) {
            $this->showEleves();
            return;
        }
        //Effectuer une derniere mise a jour en cas modification
        if (isset($this->request->ideleve)) {
            $this->validerSaisie();
        }
        # 202 Consultation des informations sur les eleves
        if (!isset($this->request->saisie) && isAuth(204)) {
            $this->showEleves();
        } else {
            $this->view->clientsJS("eleve" . DS . "eleve");
            $view = new View();

            $data = $this->Pays->selectAll();
            $paysnaiss = new Combobox($data, "paysnaiss", "IDPAYS", "PAYS");
            $nationalite = new Combobox($data, "nationalite", "IDPAYS", "PAYS");
            $nationalite->selectedid = PAYS_CAMEROUN;
            $paysnaiss->selectedid = PAYS_CAMEROUN;
            $view->Assign("paysnaiss", $paysnaiss->view());
            $view->Assign("nationalite", $nationalite->view());

            $data = $this->Etablissement->selectAll();
            $view->Assign("etablissements", $data);
            $view->Assign("provenance", $view->Render("eleve" . DS . "ajax" . DS . "comboProvenance", false));

            $view->Assign("civilite", $this->comboCivilite->view());

            $view->Assign("parente", $this->comboParente->view());
            $this->comboParente->name = "parenteextra";
            $this->comboParente->idname = "parenteextra";
            $view->Assign("parenteextra", $this->comboParente->view());

            $charges = $this->Charge->selectAll();
            $view->Assign("charges", $charges);

            $resp = $this->Responsable->selectAll();
            $comboResponsables = new Combobox($resp, "listeresponsable", "IDRESPONSABLE", "CNOM");
            $view->Assign("comboResponsables", $comboResponsables->view());

            $data = $this->Classe->selectAll();
            $classes = new Combobox($data, "classes", $this->Classe->getKey(), "NIVEAUSELECT");
            $classes->first = " ";
            $view->Assign("classes", $classes->view());
            
            $eleves = $this->Eleve->selectAll();
            $view->Assign("eleves", $eleves);
            $content = $view->Render("eleve" . DS . "saisie", false);
            $this->Assign("content", $content);
        }
    }

    /**
     * code ajax utiliser lors de la saisie d'un nouvel eleve
     * @param type $action
     */
    public function ajaxsaisie($action) {

        $provenance = empty($this->request->provenance) ? ETS_ORIGINE : $this->request->provenance;
        $params = [
            "matricule" => $this->request->matricule,
            "nom" => $this->request->nomel,
            "prenom" => $this->request->prenomel,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "photo" => $this->request->photoeleve,
            "cni" => $this->request->cni,
            "nationalite" => $this->request->nationalite,
            "datenaiss" => parseDate($this->request->datenaiss),
            "lieunaiss" => $this->request->lieunaiss,
            "paysnaiss" => $this->request->paysnaiss,
            "dateentree" => parseDate($this->request->dateentree),
            "provenance" => $provenance,
            "redoublant" => $this->request->redoublant,
        ];
        if (!empty($this->request->ideleve)) {
            $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
            $ideleve = $this->request->ideleve;
        } else {
            $this->Eleve->insert($params);
            $ideleve = $this->Eleve->lastInsertId();

            $compte = $this->Compteeleve->getBy(["ELEVE" => $ideleve]);

            if (empty($compte)) {
                $code = genererCodeCompte($ideleve, $this->request->nomel, $this->request->prenomel);

                $personnel = $this->getConnectedUser();
                $params = ["code" => $code,
                    "eleve" => $ideleve,
                    "creerpar" => $personnel['IDPERSONNEL'],
                    "datecreation" => date("Y-m-d H:i:s", time())
                ];
                $this->Compteeleve->insert($params);
            }
        }

        $json = array();
        $json[0] = $ideleve;
        $view = new View();
        switch ($action) {
            case "responsable":
                $responsables = json_decode($_POST['responsable']);
                $this->saveResponsables($responsables, $ideleve);
                $data = $this->Eleve->getResponsables($ideleve);
                $view->Assign("responsables", $data);
                $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
                break;
            case "oldresponsable":
                $resp = json_decode($_POST['responsable']);
                $params = [
                    "idresponsable" => $resp->idresponsable,
                    "ideleve" => $ideleve,
                    "parente" => $resp->parente,
                    "charges" => json_encode($resp->charges)
                ];
                $this->Responsableeleve->insert($params);
                $data = $this->Eleve->getResponsables($ideleve);
                $view->Assign("responsables", $data);
                $nonresp = $this->Eleve->getNonResponsables($ideleve);
                $view->Assign("nonresponsable", $nonresp);
                $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
                $json[2] = $view->Render("eleve" . DS . "ajax" . DS . "nonresponsable", false);
                break;
        }

        echo json_encode($json);
    }

    public function delete($id) {
        if (!isAuth(521)) {
            return;
        }
        #Supprimer le fichier image de l'eleve
        $eleve = $this->Eleve->get($id);
        $photo = $eleve['PHOTO'];
        if (!empty($photo)) {
            if (file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $photo)) {
                unlink(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $photo);
            }
        }
        $this->Eleve->delete($id);
        header("Location:" . Router::url("eleve", "saisie"));
    }

    public function ajaxindex() {
        $action = $this->request->action;
        $json = array();
        $view = new View();
        switch ($action) {
            case "editerNote":
                $note = $this->request->nouvelnote;
                $note = str_replace(",", ".", $note);
                $params = ["NOTE" => $note, "ABSENT" => 0];
                if (($note > 20) || ($note < 0) || empty($note)) {
                    $params = ["NOTE" => null,
                        "ABSENT" => 1];
                }

                $this->Note->update($params, ["IDNOTE" => $this->request->idnote]);
                break;
            case "deleteNote":
                $this->Note->delete($this->request->idnote);
                break;
        }
        if ($action === "editerNote" || $action === "deleteNote") {
            $notes = $this->Note->findBy(["ELEVE" => $this->request->ideleve]);
            $notations = array();
            foreach ($notes as $n) {
                $notations[] = $this->Notation->get($n['NOTATION']);
            }
            $view->Assign("notations", $notations);
            $view->Assign("notes", $notes);
            $json[0] = $view->Render("eleve" . DS . "ajax" . DS . "onglet5", false);
        }
        echo json_encode($json);
    }

    public function ajax() {
        $arr = array();
        $data = $this->Eleve->findBy(["IDELEVE" => $this->request->ideleve]);
        $view = new View();
        $eleve = $this->Eleve->get($this->request->ideleve);
        $view->Assign("eleve", $eleve);
        $view->Assign("nom", $data["NOM"]);
        $view->Assign("prenom", $data["PRENOM"]);
        $view->Assign("sexe", $data["SEXE"]);
        $view->Assign("datenaiss", $data["DATENAISS"]);
        $view->Assign("lieunaiss", $data["LIEUNAISS"]);
        $view->Assign("nationalite", $data["FK_NATIONALITE"]);
        $view->Assign("paysnaiss", $data["FK_PAYSNAISS"]);
        $view->Assign("dateentree", $data["DATEENTREE"]);
        $view->Assign("provenance", $data["FK_PROVENANCE"]);
        $view->Assign("datesortie", $data["DATESORTIE"]);
        $view->Assign("freresoeur", $data['FRERESOEUR']);
        $view->Assign("motifsortie", $data["FK_MOTIF"]);
        $view->Assign("residence", $data['RESIDENCE']);
        !empty($data['PHOTO']) ? $view->Assign("photo", SITE_ROOT . "public/photos/eleves/" . $data['PHOTO']) :
                        $view->Assign("photo", "");

        $classe = $this->Eleve->getClasse($this->request->ideleve, $this->session->anneeacademique);

        # Celui qui a inscrit cet eleve
        $inscription = $this->Inscription->getBy(["ideleve" => $this->request->ideleve,
            "idclasse" => $classe['IDCLASSE']]);
        $inscripteur = $this->Personnel->get($inscription['REALISERPAR']);
        $view->Assign("inscripteur", $inscripteur);

        $nbInscription = $this->Eleve->nbInscription($this->request->ideleve);
        //S'il est entree durant cette annee academique, alors nbre d'inscription est egale a 1 ou 0
        $view->Assign("nbInscription", $nbInscription[0]);

        $view->Assign("niveau", isset($classe['NIVEAUHTML']) ? $classe['NIVEAUHTML'] : "");
        $view->Assign("classe", isset($classe['LIBELLE']) ? $classe['LIBELLE'] : "");
        $view->Assign("redoublant", $this->estRedoublant($data['IDELEVE'], isset($classe['IDCLASSE']) ? $classe['IDCLASSE'] : ""));
        /**
         * ONGLET 2
         */
        $view->Assign("dataOnglet2", $this->Eleve->getResponsables($this->request->ideleve));
        /**
         * ONGLET 3
         */
        $ens = $this->Emplois->getEmplois($classe['IDCLASSE']);
        $view->Assign("enseignements", $ens);
        $horaire = $this->Horaire->selectAll();
        $heure_debut = array();
        foreach ($horaire as $line) {
            $heure_debut[] = substr($line["HEUREDEBUT"], 0, strlen($line["HEUREDEBUT"]) - 3);
        }
        $view->Assign("horaire", $horaire);
        $view->Assign("heure_debut", json_encode($heure_debut));

        # Onglet 6 Liste des notes par classe et par sequences
        $notes = $this->Note->findBy(["ELEVE" => $this->request->ideleve]);
        # Rechercher les notation de cette eleve
        $notations = array();
        foreach ($notes as $n) {
            $notations[] = $this->Notation->getBy(["IDNOTATION" => $n['NOTATION']]);
        }
        $view->Assign("notations", $notations);
        $view->Assign("notes", $notes);
        # ONGLET 6 : Suivi des absences
        $libelle = "";
        $tab = $this->getDateIntervals(PERIODE_ANNEEACADEMIQUE, $this->session->anneeacademique, $libelle);
        $view->Assign("datedebut", $tab[0]);
        $view->Assign("datefin", $tab[1]);
        # Selectionner tous les absences de cet eleve dont la date du jour de l'appel est compris entre date debut et date fin
        $absences = $this->Absence->getAbsencesEleveByPeriode($tab[0], $tab[1], $this->request->ideleve);
        $view->Assign("absences", $absences);

        # Onglet7
        $operations = $this->Caisse->findBy(["eleve" => $this->request->ideleve]);
        $view->Assign("operations", $operations);

        $view->Assign("ideleve", $this->request->ideleve);


        # affecter le contenu des vu au json
        $arr[0] = $view->Render("eleve" . DS . "ajax" . DS . "onglet1", false);
        $arr[1] = $view->Render("eleve" . DS . "ajax" . DS . "onglet2", false);
        $arr[2] = $view->Render("eleve" . DS . "ajax" . DS . "onglet3", false);
        $arr[3] = $view->Render("eleve" . DS . "ajax" . DS . "onglet4", false);
        $arr[4] = $view->Render("eleve" . DS . "ajax" . DS . "onglet5", false);
        $arr[5] = $view->Render("eleve" . DS . "ajax" . DS . "onglet6", false);
        $arr[6] = $view->Render("eleve" . DS . "ajax" . DS . "onglet7", false);
        print json_encode($arr);
    }

    //Utiliser dans la page saisie eleve et permet
    //d'uploader la photo sur le server et concerver 
    //le chemin dans un input hidden qui sera ensuite envoyer par le formulaire generale de l'eleve
    //0 pour premiere submission dont l'aaction est ajout
    //1 pour seconde soumission dont l'action est effacer
    public function photo($action) {
        $json_array = array();
        if (!strcmp($action, "upload")) {
            $photo = "";
            $message = "";
            $_FILES['photo']['name'] = preg_replace("[\ ]", "", $_FILES['photo']['name']);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], ROOT . "/public/photos/eleves/" . $_FILES['photo']['name'])) {
                $photo = SITE_ROOT . "public/photos/eleves/" . $_FILES['photo']['name'];
            } else {
                $message = "Erreur lors de la sauvegarde du fichier photo : " . $_FILES['photo']['name'];
            }

            if (!empty($photo)) {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoEleve();");
            } else {
                $json_array[0] = btn_add("savePhotoEleve();") . " " . btn_effacer_disabled("");
            }
            $json_array[1] = $photo;
            $json_array[2] = $message;
            $json_array[3] = $_FILES['photo']['name'];
        } else {
            if (file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $action)) {
                unlink(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $action);
                $json_array[0] = btn_add("savePhotoEleve();") . " " . btn_effacer_disabled("");
                $json_array[1] = "";
                $json_array[2] = "";
                $json_array[3] = "";
            } else {
                $json_array[0] = btn_add_disabled("") . " " . btn_effacer("effacerPhotoEleve();");
                $json_array[1] = $action;
                $json_array[2] = "Erreur lors de la suppression de l'image";
                $json_array[3] = "";
            }
        }
        print json_encode($json_array);
    }

    public function deleteResponsable() {
        $this->Responsableeleve->delete($this->request->idresponsableeleve);
        $json = array();
        $data = $this->Eleve->getResponsables($this->request->ideleve);
        $view = new View();
        $view->Assign("responsables", $data);
        $json[0] = $view->Render("eleve" . DS . "ajax" . DS . "responsables", false);
        $nonresponsable = $this->Eleve->getNonResponsables($this->request->ideleve);
        $view->Assign("nonresponsable", $nonresponsable);
        $json[1] = $view->Render("eleve" . DS . "ajax" . DS . "nonresponsable", false);
        echo json_encode($json);
    }

    /**
     * FUNCTION POUR L'EDITION D'UN ELEVE
     */
    public function edit($id) {
        if (!isAuth(520)) {
            return;
        }
        if (!empty($this->request->ideleve)) {
            $this->validerEdit();
        }
        $this->view->clientsJS("eleve" . DS . "edit");
        $eleve = $this->Eleve->get($id);
        $view = new View();
        /**
         * Information sur l'eleve
         */
        $view->Assign("eleve", $eleve);
        //Pays de nationalite
        $pays = $this->Pays->selectAll();
        $comboNationalite = new Combobox($pays, "nationalite", $this->Pays->getKey(), $this->Pays->getLibelle());
        $comboNationalite->selectedid = $eleve['NATIONALITE'];
        $view->Assign("comboNationalite", $comboNationalite->view());
        //Pays de naissance
        $comboNaiss = new Combobox($pays, "paysnaiss", $this->Pays->getKey(), $this->Pays->getLibelle());
        $comboNaiss->selectedid = $eleve['PAYSNAISS'];
        $view->Assign("comboNaiss", $comboNaiss->view());
        //Motif sortie
        $motif = $this->Motifsortie->selectAll();
        $comboMotifSortie = new Combobox($motif, "motifsortie", $this->Motifsortie->getKey(), $this->Motifsortie->getLibelle());
        $comboMotifSortie->first = " ";
        $comboMotifSortie->selectedid = $eleve['MOTIFSORTIE'];
        $view->Assign("comboMotifSortie", $comboMotifSortie->view());
        //Provenance
        $etablissements = $this->Etablissement->selectAll();
        $comboProvenance = new Combobox($etablissements, "provenance", $this->Etablissement->getKey(), $this->Etablissement->getLibelle());
        $comboProvenance->selectedid = $eleve['PROVENANCE'];
        $view->Assign("comboProvenance", $comboProvenance->view());
        //Liste des responsable
        $responsables = $this->Eleve->getResponsables($id);
        $view->Assign("responsables", $responsables);
        //Combo des non responsables
        $nonresponsables = $this->Eleve->getNonResponsables($id);
        $view->Assign("nonresponsables", $nonresponsables);
        //Parente
        $view->Assign("parente", $this->comboParente->view());
        $this->comboParente->name = "parenteextra";
        $this->comboParente->idname = "parenteextra";
        $view->Assign("parenteextra", $this->comboParente->view());
        //Charge
        $charges = $this->Charge->selectAll();
        $view->Assign("charges", $charges);
        //Civilite
        $view->Assign("civilite", $this->comboCivilite->view());
        # Classe
        $classe = $this->Eleve->getClasse($id, $this->session->anneeacademique);
        $view->Assign("classe", $classe);
        $content = $view->Render("eleve" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    /**
     * Effectue l'edition d'un eleve et appeller dans la methode edit
     */
    private function validerEdit() {
        $provenance = empty($this->request->provenance) ? ETS_ORIGINE : $this->request->provenance;

        $params = ["matricule" => $this->request->matricule,
            "nom" => $this->request->nomel,
            "prenom" => $this->request->prenomel,
            "autrenom" => $this->request->autrenom,
            "sexe" => $this->request->sexe,
            "residence" => $this->request->residence,
            "photo" => $this->request->photoeleve,
            "cni" => $this->request->cni,
            "nationalite" => $this->request->nationalite,
            "datenaiss" => parseDate($this->request->datenaiss),
            "paysnaiss" => $this->request->paysnaiss,
            "lieunaiss" => $this->request->lieunaiss,
            "dateentree" => parseDate($this->request->dateentree),
            "provenance" => $provenance,
            "redoublant" => $this->request->redoublant,
            "datesortie" => parseDate($this->request->datesortie),
            "motifsortie" => $this->request->motifsortie,
            "freresoeur" => $this->request->frereetsoeur];

        $this->Eleve->update($params, ["IDELEVE" => $this->request->ideleve]);
        # Verifier si l'eleve possede deja un compte caisse et inserer s'il ne le possede pas
        $compte = $this->Compteeleve->getBy(["ELEVE" => $this->request->ideleve]);

        if (empty($compte)) {
            $code = genererCodeCompte($this->request->ideleve, $this->request->nomel, $this->request->prenomel);
            $personnel = $this->getConnectedUser();
            $params = ["code" => $code,
                "eleve" => $this->request->ideleve,
                "creerpar" => $personnel['IDPERSONNEL'],
                "datecreation" => date("Y-m-d H:i:s", time())
            ];
            $this->Compteeleve->insert($params);
        }
        /**
         * Si tout s'est bien passer, rediriger vers la page eleve
         */
        header("Location:" . Router::url("eleve"));
    }

    /**
     * FUNCTION D'IMPRESSION
     */
    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            # Impression de la fiche de l'eleve
            case "0001":
                $ideleve = $this->request->ideleve;
                $eleve = $this->Eleve->findBy(["IDELEVE" => $ideleve]);
                $view->Assign("eleve", $eleve);
                $classe = $this->Eleve->getClasse($ideleve, $this->session->anneeacademique);
                $view->Assign("classe", $classe);

                # Celui qui a inscrit cet eleve
                $inscription = $this->Inscription->getBy(["ideleve" => $this->request->ideleve,
                    "idclasse" => $classe['IDCLASSE']]);
                $inscripteur = $this->Personnel->get($inscription['REALISERPAR']);
                $view->Assign("inscripteur", $inscripteur);

                $nbInscription = $this->Eleve->nbInscription($this->request->ideleve);
                //S'il est entree durant cette annee academique, alors il est nouveau et nbInsription est egale a 1 ou 0
                $view->Assign("nbInscription", $nbInscription[0]);

                $view->Assign("redoublant", $this->estRedoublant($ideleve, isset($classe['IDCLASSE']) ? $classe['IDCLASSE'] : ""));

                $responsables = $this->Eleve->getResponsables($this->request->ideleve);
                $view->Assign("responsables", $responsables);

                $ajouteur = $this->Personnel->get($eleve['ENREGISTRERPAR']);
                $view->Assign("ajouteur", $ajouteur);
                echo $view->Render("eleve" . DS . "impression" . DS . "fiche", false);
                break;
            case "0002":
                # Impression de la demande d'inscription
                $eleve = $this->Eleve->get($this->request->ideleve);
                $view->Assign("eleve", $eleve);
                $responsables = $this->Eleve->getResponsables($this->request->ideleve);
                $view->Assign("responsables", $responsables);
                $view->Assign("anneescolaire", $this->session->anneeacademique);
                echo $view->Render("eleve" . DS . "impression" . DS . "demandeinscription", false);
                break;
            # Certificat de scolarite
            case "0003":
                $eleve = $this->Eleve->get($this->request->ideleve);
                $view->Assign("eleve", $eleve);
                $view->Assign("anneescolaire", $this->session->anneeacademique);
                $classe = $this->Eleve->getClasse($this->request->ideleve, $this->session->anneeacademique);
                $view->Assign("classe", $classe);
                echo $view->Render("eleve" . DS . "impression" . DS . "certificatscolaire", false);
                break;
            # Impression de la situation financiere
            case "0004":
                $operations = $this->Caisse->getOperationsCaisse($this->request->ideleve);
                $view->Assign("operations", $operations);
                $compte = $this->Compteeleve->getBy(["eleve" => $this->request->ideleve]);
                $view->Assign("compte", $compte);
                $view->Assign("anneeacademique", $this->session->anneeacademique);
                echo $view->Render("eleve" . DS . "impression" . DS . "comptecaisse", false);
                break;
            # Impression de la liste des notes de cette eleve pour cette annee academique
            case "0005":
                $notes = $this->Note->findBy(["ELEVE" => $this->request->ideleve]);
                $eleve = $this->Eleve->get($this->request->ideleve);
                $view->Assign("notes", $notes);
                $view->Assign("eleve", $eleve);
                echo $view->Render("eleve" . DS . "impression" . DS . "listenote", false);
                break;
            # Impression de son emploi du temps
            case "0006":
                echo $view->Render("eleve" . DS . "impression" . DS . "emploistemps", false);
                break;
        }
    }

    /**
     * Renvoi vrai ou fait si cet eleve est redoublant dans cette classe
     */
    public function estRedoublant($ideleve, $idclasse) {
        /**
         * Si c'est la premiere annee de l'eleve, alors verifier dans la colonne REDOUBLANT
         * de la table eleve, sinon, obtenir le nombre de fois où il s'est inscrit dans cette classe
         */
        $nbInscription = $this->Eleve->nbInscription($ideleve);
        //S'il est entree durant cette annee academique, alors nbre d'inscription est egale a 1 ou 0
        if (count($nbInscription) <= 1) {
            $eleve = $this->Eleve->findSingleRowBy(["IDELEVE" => $ideleve]);
            return ($eleve['REDOUBLANT'] == 1);
        }
        //Sinon, rechercher le nombre de fois ou il est inscrit dans cette meme classe
        //a different annee academique
        else {
            $array_of_redoublant = $this->Classe->getRedoublants($idclasse, $this->session->anneeacademique, true);
            if (!$array_of_redoublant) {
                $array_of_redoublant = array();
            }
            if (in_array($ideleve, $array_of_redoublant)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function ajaxResponsable() {
        $view = new View();
        $resp = $this->Responsableeleve->findSingleRowBy(["IDRESPONSABLEELEVE" => $this->request->idresponsableeleve]);
        $view->Assign("responsable", $resp);
        print $view->Render("eleve" . DS . "ajax" . DS . "detailsresponsable", false);
    }

    /**
     * Notifier le parent de l'eleve dont l'id est passer entre argument
     * @param type $ideleve
     * @param string $typemessage pour quel raison faut-il notifier le parent 
     * Conf. champ typemessage de la table messages de la BD
     * 
     */
    public function notifyParents($ideleve = "", $typemessage = "") {
        # Obtenir le numero de telephone de ce parent
        $responsables = $this->Eleve->getResponsables($ideleve);

        # Obtenir de la BD le message a envoye 
        $message = $this->Messagetype->getMessage($typemessage)['MESSAGE'];

        # Proceder a la notification pour chaque responsable, s'il dispose d'un numero specifiq pour sms 
        # alors utiliser ce numero, sinon, utiliser son num portable ou son num telephone
        # Conf. Table responsables
        foreach ($responsables as $resp) {
            $tel = getRespNumPhone($resp);
            # Ne proceder a l'envoi que si le numero de telephone est non vide
            if (!empty($tel)) {
                $this->send($tel, $message);
                sleep(3);
            }
        }
    }

    public function ajaxoperation() {
        $action = $this->request->action;
        $json = array();
        $view = new View();

        switch ($action) {
            case "percuRecu":
                # Inserer la perception du montant par l'utilisateur connecter
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                $params = ["percupar" => $personnel['IDPERSONNEL'], "dateperception" => date("Y-m-d H:i:s", time())];
                $this->Caisse->update($params, ["idcaisse" => $this->request->idcaisse]);
                break;
            case "validerOperation":
                $this->Caisse->update(["valide" => 1], ["idcaisse" => $this->request->idcaisse]);
                break;
        }

        $operations = $this->Caisse->findBy(["eleve" => $this->request->ideleve]);
        $view->Assign("operations", $operations);
        $json[0] = $view->Render("caisse" . DS . "ajax" . DS . "operation", false);

        echo json_encode($json);
    }
    
    public function exclus(){
          $this->loadModel("eleveexclus");
        $view = new View();
         $this->view->clientsJS("eleve" . DS . "exclus");
        $classes = $this->Classe->selectAll();
        $comboClasses = new Combobox($classes, "classes", "IDCLASSE", "NIVEAUHTML");
        $comboClasses->first = " ";
        $view->Assign("comboClasses", $comboClasses->view());
        
        $eleves = $this->Eleveexclus->selectAll();
        $view->Assign("eleves", $eleves);
        $eleve_exclus = $view->Render("eleve" . DS  ."ajax" . DS . "tableExclus", false);
        $view->Assign("eleve_exclus", $eleve_exclus); 
        $content = $view->Render("eleve" . DS . "exclus", false);
        $this->Assign("content", $content);
    }
    public function exclusajax(){
        $action = $this->request->action;
        $view = new View();
        $json = array();
        $this->loadModel("eleveexclus");
        switch ($action){
            case "chargerExclus":
                if(!empty($this->request->classe)){
                    $eleves = $this->Eleveexclus->getEleveExclusByClasse($this->request->classe);
                }else{
                    $eleves = $this->Eleveexclus->selectAll();
                }
                $view->Assign("eleves", $eleves);
                $json[0] = $view->Render("eleve" . DS  ."ajax" . DS . "tableExclus", false);
                
                $eleves = $this->Inscription->getInscrits($this->request->classe);
                $view->Assign("eleves", $eleves);
                $json[1] = $view->Render("eleve" . DS . "ajax" .DS . "comboEleves", false);
               break;
            case "supprimerExclus":
                $this->Eleveexclus->deleteBy(["ELEVE" => $this->request->ideleve]);
                if(!empty($this->request->classe)){
                     $eleves = $this->Eleveexclus->getEleveExclusByClasse($this->request->classe);
                }else{
                    $eleves = $this->Eleveexclus->selectAll();
                }
                $view->Assign("eleves", $eleves);
                $json[0] = $view->Render("eleve" . DS  ."ajax" . DS . "tableExclus", false);
                break;
            case "ajouterExclus":
                $ideleve = $this->request->ideleve;
                $this->Eleveexclus->deleteBy(["PERIODE" => $_SESSION['anneeacademique'], "ELEVE" => $ideleve]);
                $param = ["ELEVE" => $ideleve, "PERIODE" => $_SESSION['anneeacademique']];
               
                if(empty($this->request->dateexclusion)){
                    $param["DATEEXCLUSION"] = date("Y-m-d", time());
                }else{
                    $param["DATEEXCLUSION"] = parseDate($this->request->dateexclusion);
                }
                 $this->Eleveexclus->insert($param);
                $eleves = $this->Eleveexclus->selectAll();
                $view->Assign("eleves", $eleves);
                $json[0] = $view->Render("eleve" . DS  ."ajax" . DS . "tableExclus", false);
                break;
        }
        echo json_encode($json);
    }
    
    public function existeEleveByNomEtPrenom(){
        $nom = $this->request->nom;
        $prenom = $this->request->prenom;
        $autrenom = $this->request->autrenom;
        $nb = $this->Eleve->findBy(["nom" => $nom, "prenom" => $prenom]);
        if(!$nb){
            echo 0;
        }else{
            echo 1;
        }
    }
}
