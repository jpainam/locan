<?php

/**
 * 512 : Saisie d'operation caisse
 * 522 : Impression d'un recu de caisse
 * http://www.iconarchive.com/search?q=money+icon+16x16
 */
class caisseController extends Controller {

    protected $comboJournals;
    protected $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("journal");
        $this->loadModel("compteeleve");
        $this->loadModel("personnel");
        $this->loadModel("classe");
        $this->loadModel("messagetype");
        $this->loadModel("eleve");
        $this->loadModel("frais");
        $this->loadModel("caissesupprimee");

        $journals = $this->Journal->selectAll();
        $this->comboJournals = new Combobox($journals, "comboJournals", $this->Journal->getKey(), $this->Journal->getLibelle());

        $classe = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classe, "comboClasses", $this->Classe->getKey(), ["LIBELLE", "NIVEAUSELECT"]);
    }

    public function validerSaisie() {
        $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
        # Generer la refcaisse en function du time
        //$journal = $this->Journal->get($this->request->idjournal);
        //$refcaisse = $journal['CODE'].'000'.time();
        $refcaisse = "JE" . '000' . time();

        $params = ["compte" => $this->request->idcompte,
            "type" => empty($this->request->typetransaction) ? "C" : $this->request->typetransaction,
            "reftransaction" => $this->request->reftransaction,
            "refcaisse" => $refcaisse,
            "description" => $this->request->description,
            "montant" => $this->request->montant,
            "datetransaction" => date("Y-m-d H:i:s", time()),
            "enregistrerpar" => $personnel['IDPERSONNEL'],
            "periode" => $_SESSION['anneeacademique']];

        $this->Caisse->insert($params);
        $idcaisse = $this->Caisse->lastInsertId();
        $bordereau_banque = $this->request->bordereau;
        if(!empty($bordereau_banque)){
            $this->Caisse->insertBordereauBanque($idcaisse, $bordereau_banque);
        }
        header("Location:" . Router::url("caisse", "recu", $idcaisse));
    }

    /**
     * Code droit 512: Saisie d'une operation caise
     */
    public function saisie() {
        if (!isAuth(512)) {
            return;
        }

        if (!empty($this->request->reftransaction)) {
            $this->validerSaisie();
        }
        $this->view->clientsJS("caisse" . DS . "saisie");
        $view = new View();

        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $content = $view->Render("caisse" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie() {
        $action = $this->request->action;
        $json = array();
        $view = new View();

        switch ($action) {
            case "chargerComptes":
                $comptes = $this->Compteeleve->getComptesByClasse($this->request->idclasse);
                $view->Assign("comptes", $comptes);
                $json[0] = $view->Render("caisse" . DS . "ajax" . DS . "comboComptes", false);
                break;
            case "chargerPhoto":
                $compte = $this->Compteeleve->get($this->request->idcompte);
                $json[0] = SITE_ROOT . "public/photos/eleves/" . $compte['PHOTO'];
                break;
        }
        echo json_encode($json);
    }

    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            # Impression de l'etat de ce compte caisse eleve
            case "0001":
                $compte = $this->Compteeleve->get($this->request->idcompte);
                $operations = $this->Caisse->getOperationsCaisse($compte['ELEVE']);
                $view->Assign("operations", $operations);
                $view->Assign("compte", $compte);
                $view->Assign("anneeacademique", $this->session->anneeacademique);
                echo $view->Render("eleve" . DS . "impression" . DS . "comptecaisse", false);
                break;

            # Impression du recu de caisse
            case "0002":
                # Inserer la perception du montant par l'utilisateur connecter
                $caisse = $this->Caisse->get($this->request->idcaisse);
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);

                if (empty($caisse['PERCUPAR'])) {
                    $params = ["percupar" => $personnel['IDPERSONNEL'], "dateperception" => date("Y-m-d H:i:s", time())];
                    $this->Caisse->update($params, ["idcaisse" => $this->request->idcaisse]);
                    # Envoi du SMS a ce numero
                    $this->notifyVersement();
                }
                if (empty($caisse['IMPRIMERPAR'])) {
                    $params = ["imprimerpar" => $personnel['IDPERSONNEL'], "dateimpression" => date("Y-m-d H:i:s", time())];
                    $this->Caisse->update($params, ["idcaisse" => $this->request->idcaisse]);
                }
                # imprimer le recu
                $operation = $this->Caisse->get($this->request->idcaisse);
                $view->Assign("operation", $operation);
                $view->Assign("personnel", $personnel);

                $percepteur = $this->Personnel->get($operation['PERCUPAR']);
                $view->Assign("percepteur", $percepteur);

                $enregistreur = $this->Personnel->get($operation['ENREGISTRERPAR']);
                $view->Assign("enregistreur", $enregistreur);

                $classe = $this->Eleve->getClasse($operation['ELEVE'], $this->session->anneeacademique);
                $view->Assign("classe", $classe);
                $montantapayer = $this->Frais->getClasseTotalFrais($classe['IDCLASSE']);
                $view->Assign("montantapayer", $montantapayer);

                $montantpayer = $this->Caisse->getMontantPayer($operation['ELEVE']);
                $view->Assign("montantpayer", $montantpayer);
                echo $view->Render("caisse" . DS . "impression" . DS . "recu", false);
                break;
            case "0003":
            case "0004":
                $soldes = $this->Classe->getSoldeAllEleves();
                $montanfraisapplicable = $this->Frais->getAllFraisApplicables();
                $montantfrais = $this->Frais->getClasseSommeFrais();
                $view->Assign("soldes", $soldes);
                $view->Assign("montantfrais", $montantfrais);
                $view->Assign("montantfraisapplicable", $montanfraisapplicable);
                if ($this->request->code === "0003") {
                    $view->Assign("type", "debit");
                } else {
                    $view->Assign("type", "credit");
                }
                echo $view->Render("caisse" . DS . "impression" . DS . "situationfinanciere", false);
                break;
        }
    }

    /**
     * Impression d'un recu grace a l'operation caisse idcaisse
     * Afficher avant de proposer une impression
     * @param type $idcaisse
     */
    public function recu($idcaisse) {
        if (!isAuth(522)) {
            return;
        }
        $this->view->clientsJS("caisse" . DS . "recu");
        $view = new View();
        $operation = $this->Caisse->get($idcaisse);

        $view->Assign("operation", $operation);

        $this->loadBarcode(BARCODE_1);
        $barcodeobj = new TCPDFBarcode($operation['REFCAISSE'], 'C128A');
        $view->Assign("barcode", $barcodeobj->getBarcodeHTML(1, 35, 'black'));

        $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);

        if (!empty($operation['PERCUPAR'])) {
            $percepteur = $this->Personnel->get($operation['PERCUPAR']);
            $view->Assign("percepteur", $percepteur);
        }

        if (!empty($operation['IMPRIMERPAR'])) {
            $imprimeur = $this->Personnel->get($operation['IMPRIMERPAR']);
        } else {
            $imprimeur = $personnel;
        }

        $percepteur = $this->Personnel->get($operation['PERCUPAR']);
        $view->Assign("percepteur", $percepteur);

        $enregistreur = $this->Personnel->get($operation['ENREGISTRERPAR']);
        $view->Assign("enregistreur", $enregistreur);

        $view->Assign("imprimeur", $imprimeur);
        $view->Assign("estDirectrice", ($this->session->idprofile === DIRECTOR_PROFILE) ? true : false);

        $classe = $this->Eleve->getClasse($operation['ELEVE'], $this->session->anneeacademique);
        $view->Assign("classe", $classe);
        $montantapayer = $this->Frais->getClasseTotalFrais($classe['IDCLASSE']);
        $view->Assign("montantapayer", $montantapayer);

        $montantpayer = $this->Caisse->getMontantPayer($operation['ELEVE']);
        $view->Assign("montantpayer", $montantpayer);
        $content = $view->Render("caisse" . DS . "recu", false);
        $this->Assign("content", $content);
    }

    public function notifyVersement($typemessage = "0006") {
        $operation = $this->Caisse->get($this->request->idcaisse);
        $this->activateSMS();
        # Obtenir de la BD le message a envoye 
        $sms = $this->Messagetype->getMessage($typemessage)['MESSAGE'];

        $params = [
            "#montant " => $operation['MONTANT'],
            "#eleve " => $operation['NOMEL'],
            "#refcaisse " => $operation['REFCAISSE']];


        $message = $this->personnalize($params, $sms);
        $responsables = $this->Eleve->getResponsables($operation['ELEVE']);
        foreach ($responsables as $resp) {
            $tel = getRespNumPhone($resp);
            if (!empty($tel)) {
                $this->send($tel, $message);
                sleep(5);
            }
        }
    }

    public function operation() {
        $this->view->clientsJS("caisse" . DS . "operation");
        $view = new View();
        $this->comboJournals->first = "Tous les journaux";
        $view->Assign("comboJournals", $this->comboJournals->view());
        $operations = $this->Caisse->selectAll();

        $totaux = $this->Caisse->getMontantTotaux();

        $view->Assign("totaux", $totaux);

        $view->Assign("operations", $operations);
        $tableOperation = $view->Render("caisse" . DS . "ajax" . DS . "operation", false);
        $view->Assign("tableOperation", $tableOperation);
        $operations = $this->Caissesupprimee->selectAll();
        $view->Assign("operations", $operations);
        $operationSupprimes = $view->Render("caisse" . DS . "ajax" . DS . "operationsupprimee", false);

        $view->Assign("operationSupprimes", $operationSupprimes);
        $content = $view->Render("caisse" . DS . "operation", false);
        $this->Assign("content", $content);
    }

    public function ajaxoperation() {
        $action = $this->request->action;
        $json = array();
        $view = new View();
        $datedebut = parseDate($this->request->datedebut);
        $datefin = parseDate($this->request->datefin);
        switch ($action) {
            case "validerOperation" :
                $this->Caisse->update(["valide" => 1], ["idcaisse" => $this->request->idcaisse]);
                break;
            case "percuRecu" :
                # Inserer la perception du montant par l'utilisateur connecter
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                $params = ["percupar" => $personnel['IDPERSONNEL'],
                    "dateperception" => date("Y-m-d H:i:s", time())];
                $this->Caisse->update($params, ["idcaisse" => $this->request->idcaisse]);
                # Envoi du SMS a ce numero
                $this->notifyVersement();
                break;
        }


        # 1 = Operation en cours, 2 = Operation validee, 3 = Operation dont le montant est percue
        $filtre = $this->request->filtre;

        if (empty($datedebut)) {
            $datedebut = "1970-01-01";
        }
        if ($filtre == 1) {
            $operations = $this->Caisse->getOperationsEncours($datedebut, $datefin);
        } elseif ($filtre == 2) {
            $operations = $this->Caisse->getOperationsValidees($datedebut, $datefin);
        } elseif ($filtre == 3) {
            $operations = $this->Caisse->getOperationsPercues($datedebut, $datefin);
        } elseif (!empty($this->request->datedebut)) {
            $operations = $this->Caisse->getOperationsByJour($datedebut, $datefin);
        } else {
            $operations = $this->Caisse->selectAll();
        }
        $view->Assign("operations", $operations);
        $json[0] = $view->Render("caisse" . DS . "ajax" . DS . "operation", false);

        # montant

        $totaux = $this->Caisse->getMontantTotaux($datedebut, $datefin);
        $view->Assign("totaux", $totaux);
        $json[1] = $view->Render("caisse" . DS . "ajax" . DS . "tableTotaux", false);
        echo json_encode($json);
    }

    public function delete($idcaisse) {
        $op = $this->Caisse->get($idcaisse);
        $params = [
            "compte" => $op['COMPTE'],
            "type" => $op['TYPE'],
            "reftransaction" => $op['REFTRANSACTION'],
            "refcaisse" => $op['REFCAISSE'],
            "description" => $op['DESCRIPTION'],
            "montant" => $op['MONTANT'],
            "datetransaction" => $op['DATETRANSACTION'],
            "enregistrerpar" => $op['ENREGISTRERPAR'],
            "percupar" => $op['PERCUPAR'],
            "dateperception" => $op['DATEPERCEPTION'],
            "imprimerpar" => $op['IMPRIMERPAR'],
            "dateimpression" => $op['DATEIMPRESSION'],
            "valide" => $op['VALIDE'],
            "periode" => $op['PERIODE']
        ];
        $this->Caissesupprimee->insert($params);
        $this->Caisse->delete($idcaisse);
        header("Location:" . Router::url("caisse", "operation"));
    }

    public function restaurer($idcaisse) {
        $op = $this->Caissesupprimee->get($idcaisse);
        $params = [
            "compte" => $op['COMPTE'],
            "type" => $op['TYPE'],
            "reftransaction" => $op['REFTRANSACTION'],
            "refcaisse" => $op['REFCAISSE'],
            "description" => $op['DESCRIPTION'],
            "montant" => $op['MONTANT'],
            "datetransaction" => $op['DATETRANSACTION'],
            "enregistrerpar" => $op['ENREGISTRERPAR'],
            "percupar" => $op['PERCUPAR'],
            "dateperception" => $op['DATEPERCEPTION'],
            "imprimerpar" => $op['IMPRIMERPAR'],
            "dateimpression" => $op['DATEIMPRESSION'],
            "valide" => $op['VALIDE'],
            "periode" => $op['PERIODE']
        ];
        $this->Caisse->insert($params);
        $this->Caissesupprimee->delete($idcaisse);
        header("Location:" . Router::url("caisse", "operation"));
    }

    public function ajaxobservation() {
        $json = array();
        $view = new View();
        $action = $this->request->action;
        $idcaisse = $this->request->idcaisse;
        $caisse = $this->Caissesupprimee->get($idcaisse);
        switch ($action) {
            case "getobservation":
                $json[0] = empty($caisse['DATEOBSERVATION']) ? date("Y-m-d", time()) : $caisse['DATEOBSERVATION'];
                $json[1] = $caisse['OBSERVATIONS'];
                break;
            case "miseajour":
                $json[0] = "Mise &agrave; effectu&eacute;e avec succ&egrave;s";
                if (!isAuth(535) && !isAuth(536)) {
                    $json[0] = "Impossible!!!\nVous ne disposez d'aucun droit sur les observations de caisses";
                } else {
                    $params = ["dateobservation" => parseDate($this->request->dateobservation),
                        "observations" => $this->request->observations];
                    $ok = true;
                    if (empty($caisse['OBSERVATIONS'])) {
                        if (!isAuth(535)) {
                            $json[0] = "Vous ne disposez pas du droit de saisie sur les observations de caisse";
                            $ok = false;
                        }
                    } else {
                        if (!isAuth(536)) {
                            $json[0] = "Vous ne disposez pas du droit de modification sur les observations de caisses";
                            $ok = false;
                        }
                    }
                    if ($ok) {
                        $this->Caissesupprimee->update($params, ["idcaisse" => $idcaisse]);
                        $operations = $this->Caissesupprimee->selectAll();
                        $view->Assign("operations", $operations);
                        $json[1] = $view->Render("caisse" . DS . "ajax" . DS . "operationsupprimee", false);
                    }
                }
                break;
        }
        print json_encode($json);
    }

}
