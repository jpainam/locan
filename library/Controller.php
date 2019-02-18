<?php

class Controller extends Application {

    protected $view = null;
    protected $school = null;

    public function __construct() {

        parent::__construct();

        global $url; //$url est une variable globale defini dans Router.php
        $urlArray = explode("/", $url);
        /**
          Conservation de l'url de la page active
         */
        if ($urlArray[0] != "connexion") {
            $_SESSION['activeurl'] = $url;
        }

        //Extraire le mot Eleve dans la chaine EleveController (par exple)
        $model = strtolower(substr(get_class($this), 0, strlen(get_class($this)) - 10));
        $this->loadModel($model);
        $this->getInfoSchool();
        //Verifier si ce n'est pas une requete AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //Charger la page template, confere destructeur __destruct
            $this->view = new View();
            $this->view->Assign("authentified", isset($this->session->user));
            //Peut se faire directement dans le template
            //Charger le CSS
            //$this->view->setCSS('public' . DS . 'css' . DS . 'style.css');
            //charger le titre de la page
            //$this->view->setSiteTitle('Logiciel de gestion des activit&eacute;s acad&eacute;miques');
            //HEADER GENERALE
            $header = new View();
            $header->Assign('app_title', "LOCAN");
            $header->Assign("authentified", (isset($this->session->user)));

            if (isset($this->session->user)) {
                $header->Assign("menu", $this->menus->getMenus());
            }
            $this->Assign('header', $header->Render('header', false));


            //FOOTER GENERALE
            $footer = new View();
            $this->Assign('footer', $footer->Render('footer', false));
        }
    }

    public function index() {
        $this->Assign('content', 'methode index de classe ' . get_class($this) . ', Methode non encore
		implementee pour cette classe qui doit etendre le controller');
    }

    function Assign($variable, $value) {
        $this->view->Assign($variable, $value);
    }

    protected function loadModel($model) {
        $modelName = strtolower($model) . 'Model';
        if (class_exists($modelName)) {
            $model = ucfirst(strtolower($model));
            $this->{$model} = new $modelName;
        } else {
            die("Classe $modelName n'existe pas");
        }
    }

    function loadView($name) {

        //echo ROOT . DS . 'views' . DS . strtolower($name) . 'php';
        /* if (file_exists(ROOT . DS . 'views' . DS . strtolower($name) . '.php')) {
          $this->view_name = $name;
          } */
    }

    function __destruct() {
        if ($this->view != null && $this->pdf == null) {
            $this->view->Render('template');
        }
    }

    /**
     * Generer le breadcrum en function du menu
     */
    public function setBreadCrumb() {
        return '<div class="breadcrumb"><a href ="">Document</a><a  href ="">Document</a><a href ="">Document</a></div>';
    }

    public function printable() {
        $this->pdf = new PDF();
    }

    public function getFreeDays() {
        $this->loadModel("fermeture");
        $this->loadModel("ferie");
        $this->loadModel("vacance");

        $calendrier = new ArrayObject();

        $fermer = $this->Fermeture->findBy(["PERIODE" => $this->session->anneeacademique]);
        $feries = $this->Ferie->findBy(["PERIODE" => $this->session->anneeacademique]);
        $vacance = $this->Vacance->findBy(["PERIODE" => $this->session->anneeacademique]);
        foreach ($feries as $f) {
            $calendrier->offsetSet($f['DATEFERIE'], "F");
        }

        # Date pour lesquelles l'etablissement est ferme
        foreach ($fermer as $f) {
            $date = $f['DATEDEBUT'];
            $datefin = $f['DATEFIN'];
            while ($date <= $datefin) {
                $calendrier->offsetSet($date, "C");
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        }

        # Date pour lesquelles l'etablissement est en vacance
        foreach ($vacance as $v) {
            $date = $v['DATEDEBUT'];
            $datefin = $v['DATEFIN'];
            while ($date <= $datefin) {
                $calendrier->offsetSet($date, "V");
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
        }
        # Voulant trier le calendrier par cle, mais sort ne trie que sur les valeurs
        return $calendrier;
    }

    /**
     * 
     * @param type $periode 1 = par mois; 2 = par sequence, 3 = par trimestre et 4 = par anneeacademique
     * @param type $distribution 
     * <ol>
     *  <li>si $periode = 1, alors $distribution est une lvalue compris entre 1 a 11 où 1 = Septembre, 2 = Octobre ... 11 = Juillet</li>
     *  <li>si $periode = 2, alors $distribution est une IDSEQUENCE avec libelle, 1ere sequence, 2nde sequence ... Confere table sequences dans la BD</li>
     *  <li>si $periode = 3, alors $distribution est une IDTRIMESTRE avec libelle, 1er Trimestre, 2nd Trimestre... Confere table trimestres dans la BD</li>
     *  <li>si $periode = 4, alors $distribution est une ANNEEACADEMIQUE 2014-2015 avec libelle 2014-2015... Confere table anneeacademique dans la BD</li>
     * </ol> 
     * @param type $libelle
     * @return array contenant la date de debut et de fin de la periode 
     */
    protected function getDateIntervals($periode, $distribution, &$libelle = "") {
        $this->loadModel("trimestre");
        $this->loadModel("anneeacademique");
        $this->loadModel("sequence");
        $tab = array();
        if ($periode == 1) {
            $libelle = getMonthOfTheYear($this->session->anneeacademique)[$distribution];
        }
        # Mensuelle
        if ($periode == PERIODE_MENSUELLE) {
            return getIntervaleOfMonth($distribution);
        }
        # Sequence
        elseif ($periode == PERIODE_SEQUENCE) {
            $sequence = $this->Sequence->findSingleRowBy(["IDSEQUENCE" => $distribution]);
            $tab[0] = $sequence['DATEDEBUT'];
            $tab[1] = $sequence['DATEFIN'];
            $libelle = $sequence['LIBELLE'];
        }
        # Trimestre 
        elseif ($periode == PERIODE_TRIMESTRE) {
            $trimestre = $this->Trimestre->findSingleRowBy(["IDTRIMESTRE" => $distribution]);
            $tab[0] = $trimestre['DATEDEBUT'];
            $tab[1] = $trimestre['DATEFIN'];
            $libelle = $trimestre['LIBELLE'];
        }
        #Annee
        elseif ($periode == PERIODE_ANNEEACADEMIQUE) {
            $annee = $this->Anneeacademique->findSingleRowBy(["ANNEEACADEMIQUE" => $distribution]);
            $tab[0] = $annee['DATEDEBUT'];
            $tab[1] = $annee['DATEFIN'];
            $libelle = $annee['ANNEEACADEMIQUE'];
        }
        return $tab;
    }

    public function updateMenu() {
        //print $this->request->tab;
        $this->loadModel("user");
        $param = array(
            "ETATMENU" => $this->request->tab
        );
        $key = array(
            "LOGIN" => $this->request->user
        );
        $this->User->update($param, $key);
    }

    public function loadBarcode($type) {
        if ($type === BARCODE_1) {
            include "tcpdf/tcpdf_barcodes_1d.php";
        }
    }

    public function loadJPGraph() {
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_bar.php');
        require_once ('jpgraph/jpgraph_error.php');
        require_once ('jpgraph/jpgraph_mgraph.php');
        require_once ('jpgraph/jpgraph_utils.inc.php');
        require_once ('jpgraph/jpgraph_iconplot.php');
        require_once ('jpgraph/jpgraph_plotline.php');
    }

    public function getInfoSchool() {
        $this->loadModel("locan");
        $this->school = $this->Locan->get(MAIN_ETABLISSEMENT);
    }

    /**
     * Verifier si cet eleve peut s'inscrire en verifiant son solde de l'annee passee
     * @param type $ideleve
     * @return boolean * 
     */
    public function estInscrivable($ideleve) {
        $this->loadModel("eleve");
        $this->loadModel("frais");
        $this->loadModel("caisse");

        $previousyear = getPreviousAnneeAcademique($_SESSION['anneeacademique']);
        $previousclasse = $this->Eleve->getClasse($ideleve, $previousyear);
        
        if (!empty($previousclasse)) {
            $montantapayer = $this->Frais->getClasseTotalFrais($previousclasse['IDCLASSE']);
            $montantpayer = $this->Caisse->getMontantPayer($ideleve, $previousyear);
           
            return ($montantpayer['MONTANTPAYER'] - $montantapayer['TOTALFRAIS']);
        }
        return 0;
    }

    /**
     * Inscrit l'eleve ideleve dans classe idclasse
     * @param type $ideleve
     * @param type $idclasse
     * @return boolean
     */
    public function inscrire($ideleve, $idclasse) {
        $personnel = $this->getConnectedUser();
        # Verifier si l'eleve possede deja un compte caisse et inserer s'il ne le possede pas
        $compte = $this->Compteeleve->getBy(["ELEVE" => $ideleve]);

        if (empty($compte)) {
            $eleve = $this->Eleve->get($ideleve);
            $code = genererCodeCompte($ideleve, $eleve['NOM'], $eleve['PRENOM']);
            $params = ["code" => $code,
                "eleve" => $ideleve,
                "creerpar" => $personnel['IDPERSONNEL'],
                "datecreation" => date("Y-m-d H:i:s", time())
            ];
            $this->Compteeleve->insert($params);
        }

        $params = ["IDELEVE" => $ideleve,
            "IDCLASSE" => $idclasse,
            "ANNEEACADEMIQUE" => $this->session->anneeacademique,
            "realiserpar" => $personnel['IDPERSONNEL']
        ];
        if ($this->Inscription->insert($params)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Definir le matricule pour les eleve n'ayant pas deja de matricule
     * @param type $ideleve
     */
    public function updateMatricule($ideleve, $idclasse) {
        $eleve = $this->Eleve->get($ideleve);
        if (empty(trim($eleve['MATRICULE']))) {
            # Retourne 15 dans le cas ou ANNEACADEMIQUE = 2014-2015
            $matric = substr($this->session->anneeacademique, -2);

            # Obtenir le niveau de la classe
            $classe = $this->Classe->getBy(["IDCLASSE" => $idclasse]);

            # Concatener le niveau au matric
            if ($classe['GROUPE'] == 0) {
                $matric .= "T";
            } else {
                $matric .= $classe['GROUPE'];
            }
            # Obtenir les infos du dernier eleve inscrit dans cette classe
            $derniereleve = $this->Classe->findLastEleveFromGroupe($classe['GROUPE'], $matric);

            $matricule = genererMatricule($derniereleve, $matric);
            # Mettre a jour son matricule a proprement parle
            $this->Eleve->update(["MATRICULE" => $matricule], ["IDELEVE" => $ideleve]);
        }
    }

    public function getConnectedUser() {
        $this->loadModel("personnel");
        return $this->Personnel->getBy(["USER" => $this->session->iduser]);
    }

}
