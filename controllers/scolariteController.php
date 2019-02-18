<?php
/**
 * 508 : Effectuer un payement
 * 519: Supprimer un payement precedemment effectuer par le droit 508
 */
class scolariteController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("inscription");
        $this->loadModel("frais");
        $this->loadModel("compteeleve");
        $this->loadModel("caisse");
        $this->loadModel("classe");
        $this->loadModel("personnel");

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), $this->Classe->getLibelle());
    }

    public function index() {
     
    }

    function payement() {
        if(!isAuth(508)){
            return;
        }
        $this->view->clientsJS("scolarite" . DS . "payement");
        $view = new View();

        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $content = $view->Render("scolarite" . DS . "payement", false);
        $this->Assign("content", $content);
    }

    public function ajaxpayement() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        
        switch ($action) {
            case "chargerFrais":
                $frais = $this->Frais->findBy(["CLASSE" => $this->request->idclasse]);
                $view->Assign("frais", $frais);
                $json[0] = $view->Render("scolarite" . DS . "ajax" . DS . "comboFrais", false);
                break;
            case "payer":
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);

                $params = ["eleve" => $this->request->ideleve,
                    "frais" => $this->request->idfrais,
                    "datepayement" => date("Y-m-d", time()),
                    "realiserpar" => $personnel['IDPERSONNEL']
                ];
                $this->Scolarite->insert($params);
                break;
            case "depayer":
                $this->Scolarite->delete($this->request->idscolarite);
                break;
        }
        if ($action != "chargerFrais") {
            $frais = $this->Frais->get($this->request->idfrais);
            $eleves = $this->Scolarite->getScolariteEleveByFrais($this->request->idfrais);
            $view->Assign("eleves", $eleves);
            
            $json[0] = $view->Render("scolarite" . DS . "ajax" . DS . "payement", false);
            
            # Montant frais pour les info d'entete
            $json[1] = "## ". $frais['MONTANT'] ." ##";
            
            # Date echeances
            $d = new DateFR($frais['ECHEANCES']);
            $json[2] = $d->getJour(3)." ".$d->getDate()." ".$d->getMois(3)." ".$d->getYear();
        }
        echo json_encode($json);
    }

    public function ajax($action) {
        $view = new View();
        $json = array();
        $compte = $this->Compteeleve->findSingleRowBy(["ELEVE" => $this->request->eleve]);
        switch ($action) {
            case "supprimer":
                $this->Scolarite->delete($this->request->idscolarite);
                break;
            case "charger":
                //Frais dont l'eleve doit payer
                $frais = $this->Frais->getEleveFrais($this->request->eleve, $this->session->anneeacademique);
                $view->Assign("frais", $frais);
                $json[1] = $view->Render("scolarite" . DS . "ajax" . DS . "comboFrais", false);
                $caisses = $this->Caisse->findBy(["COMPTE" => $compte['IDCOMPTE']]);
                $view->Assign("caisses", $caisses);
                $json[2] = $view->Render("scolarite" . DS . "ajax" . DS . "comboCaisses", false);
                break;
            case "ajout":
                $frais = $this->Frais->findSingleRowBy(["IDFRAIS" => $this->request->idfrais]);
                //Rechercher le montant lie a cette operation caisse
                $caisse = $this->Caisse->findSingleRowBy(['IDCAISSE' => $this->request->idcaisse]);
                /**
                 * Rechercher tous le total des payement se basant sur cette operation caisse
                 */
                $total = $this->Scolarite->getTotalByCaisse($this->request->idcaisse);
                /**
                 * definir le montant du payement = montant de l'operation caisse - montant total des scolarite se basant
                 * sur cette operation caisse
                 */
                $montantscolarite = intval($caisse['MONTANT']) - intval($total['TOTAL']);
                if ($montantscolarite == 0) {
                    $json[1] = $caisse['MONTANT'];
                } else {
                    $montant = $montantscolarite < $frais['MONTANT'] ? $montantscolarite : $frais['MONTANT'];
                    $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);

                    $params = ["eleve" => $this->request->eleve, "frais" => $this->request->idfrais,
                        "montant" => $montant,
                        "datepayement" => date("Y-m-d", time()), "anneeacademique" => $this->session->anneeacademique,
                        "realiserpar" => $personnel['IDPERSONNEL']];
                    $this->Scolarite->insert($params);
                    //Debiter le compte
                    $json[1] = '';
                }
                break;
        }
        $scolarites = $this->Scolarite->getScolarites($this->request->eleve, $this->session->anneeacademique);
        $view->Assign("scolarites", $scolarites);
        $json[0] = $view->Render("scolarite" . DS . "ajax" . DS . "scolarite", false);
        echo json_encode($json);
    }

}
