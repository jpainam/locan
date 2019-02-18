<?php

class userController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("connexion");
        $this->loadModel("droit");
        $this->loadModel("personnel");
        $this->loadModel("profile");
    }

    public function index() {
        if (!isAuth(603)) {
            return;
        }
        $this->view->clientsJS("user" . DS . "index");
        $view = new View();
        $users = $this->User->selectAll();
        $view->Assign("users", $users);
        $content = $view->Render("user" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function saisie() {
        if (!isAuth(607)) {
            return;
        }
        $view = new View();
        $view->Assign("errors", false);
        #Validation du formulaire
        if (!empty($this->request->login) && !empty($this->request->personnel)) {
            # Verifier si le login n'existe pas deja
            $user = $this->User->getBy(["LOGIN" => $this->request->login]);
            if (!empty($user)) {
                $view->Assign("errors", true);
                $view->Assign("user", $user['LOGIN']);
            } else {
                $params = ["login" => $this->request->login,
                    "password" => md5($this->request->pwd),
                    "profile" => $this->request->profile,
                    "etatmenu" => "0000000000",
                    "droitspecifique" => "[\"101\",\"102\",\"104\",\"105\"]"
                    ];

                $this->User->insert($params);
                $iduser = $this->User->lastInsertId();
                $this->Personnel->update(["USER" => $iduser], ['IDPERSONNEL' => $this->request->personnel]);
                header("Location:" . Router::url("user"));
            }
        }

        $this->view->clientsJS("user" . DS . "user");

        $personnels = $this->User->getFreePersonnels();
        $comboPersonnels = new Combobox($personnels, "personnel", $this->Personnel->getKey(), ["NOM", "PRENOM"]);
        $comboPersonnels->first = " ";
        $comboPersonnels->required = true;
        $view->Assign("comboPersonnels", $comboPersonnels->view());

        $profiles = $this->Profile->selectAll();
        $comboProfiles = new Combobox($profiles, "profile", $this->Profile->getKey(), $this->Profile->getLibelle());
        $comboProfiles->required = true;
        $comboProfiles->first = " ";
        $view->Assign("comboProfiles", $comboProfiles->view());

        $content = $view->Render("user" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function delete($id) {
        $this->User->delete($id);
        header("Location:" . Router::url("user"));
    }

    public function droit() {
        if (!isAuth(606)) {
            return;
        }

        $this->view->clientsJS("user" . DS . "droit");
        if (!empty($this->request->iduser)) {
            $droits = json_encode($_POST['droits']);
            $this->User->update(["DROITSPECIFIQUE" => $droits], ["IDUSER" => $this->request->iduser]);
        }
        $view = new View();

        $data = $this->User->selectAll();
        $comboUser = new Combobox($data, "listeusers", "IDUSER", "LOGIN");
        $comboUser->first = " ";
        $view->Assign("comboUser", $comboUser->view());


        $data = $this->Connexion->selectAll();
        $grid = new Grid($data, 0);

        $grid->addcolonne(0, "IDCONNEXION", "IDCONNEXION", false);
        $grid->addcolonne(1, "Compte", "COMPTE");
        $grid->addcolonne(2, "Date de d&eacute;but", "DATEDEBUT");
        $grid->addcolonne(3, "Machine", "MACHINESOURCE");
        $grid->addcolonne(4, "Adresse", "IPSOURCE");
        $grid->addcolonne(5, "Connexion", "CONNEXION");
        $grid->addcolonne(6, "Date de fin", "DATEFIN");
        $grid->addcolonne(7, "D&eacute;connexion", "DECONNEXION");
        $grid->dataTable = "connexionTable";
        $grid->setColDate(2);
        $grid->setColDate(6);
        $total = count($data);
        $view->Assign("connexions", $grid->display());

        $droits = $this->Droit->selectAll();
        $grid = new Grid($droits, 0);
        $grid->addcolonne(0, "ID", "IDDROIT", false);
        $grid->addcolonne(1, "CODE", "CODEDROIT");
        $grid->addcolonne(2, "LIBELLE", "LIBELLE");
        $grid->dataTable = "droitTable";
        $view->Assign("droits", $grid->display());
        $view->Assign("total", $total);
        $content = $view->Render("user" . DS . "droit", false);
        $this->Assign("content", $content);
    }

    /**
     * affiche la grid des differents connexion de l'utilisateur
     */
    public function connexion() {

        $this->view->clientsJS("user" . DS . "connexion");

        $data = $this->User->mesConnexions($this->input->session('user'));
        $grid = new Grid($data, 0);

        $grid->addcolonne(0, "IDCONNEXION", "IDCONNEXION", false);
        $grid->addcolonne(1, "Date de début", "DATEDEBUT");
        $grid->addcolonne(2, "Machine", "MACHINESOURCE");
        $grid->addcolonne(3, "Adresse", "IPSOURCE");
        $grid->addcolonne(4, "Connexion", "CONNEXION");
        $grid->addcolonne(5, "Date de fin", "DATEFIN");
        $grid->addcolonne(6, "Déconnexion", "DECONNEXION");

        $grid->setColDate(1);
        $grid->setColDate(5);
        $total = count($data);
        $grid->dataTable = "tableConnexion";

        $view = new View();
        $view->Assign("connexions", $grid->display());
        $view->Assign("errors", false);
        $view->Assign("total", $total);
        $content = $view->Render("user" . DS . "connexion", false);
        $this->Assign("content", $content);
    }

    public function mdp() {
        $view = new View();
        $view->Assign("errors", false);
        $message = "";
        //Validation du formulaire
        if (isset($this->request->pwdactuel) && isset($this->request->newpwd) && isset($this->request->confpwd)) {
            //Verifier que newpwd et le mot de passe de confirmation sont identique
            if (strcmp($this->request->newpwd, $this->request->confpwd)) {
                $message = "Le nouveau mot de passe et celui de confirmation ne correspondent pas";
            } else {
                //Verifier que l'ancien mot de passe est correcte
                $user = $this->User->findBy(array("LOGIN" => $this->session->user, "PASSWORD" => md5($this->request->pwdactuel)));
                if (is_array($user) && count($user) > 0) {

                    if ($this->User->update(["PASSWORD" => md5($this->request->newpwd)], ["LOGIN" => $this->session->user])) {
                        header("Location:" . Router::url("connexion", "disconnect"));
                    } else {
                        $message = "Une erreur de mise a jour";
                    }
                } else {
                    $message = "Mot de passe actuel incorrect";
                }
            }
        }
        if (!empty($message)) {
            $view->Assign("errors", true);
            $view->Assign("message", $message);
        }
        $content = $view->Render("user" . DS . "mdp", false);
        $this->Assign("content", $content);
    }

    /**
     * Modification de son adresse email
     */
    public function email() {
        $view = new View();
        $view->Assign("errors", false);
        $user = $this->User->findSingleRowBy(["LOGIN" => $this->session->user]);
        $iduser = $user['IDUSER'];

        $message = "";
        if (!empty($this->request->email)) {
            //verifier si c'est un email valide en utilisant une expression reguliere
            $valide = true;
            if ($valide) {

                if ($this->Personnel->update(['EMAIL' => $this->request->email], ["USER" => $iduser])) {
                    header("Location:" . Router::url("personnel"));
                }
            } else {
                $view->Assign("errors", true);
                $message = "Format d'email invalide";
            }
        }
        if (isset($this->request->email) && empty($this->request->email)) {
            $view->Assign("errors", true);
            $message = "Veuillez remplir le champ email";
        }
        $view->Assign("message", $message);

        $this->Assign("content", $view->output());
    }

    public function telephone() {
        if(!isAuth(104)){
            return;
        }
        $view = new View();
        $view->Assign("errors", false);
        $this->loadModel("personnel");
        $user = $this->User->findSingleRowBy(["LOGIN" => $this->session->user]);
        $iduser = $user['IDUSER'];

        //Validation du formulaire
        if (!empty($this->request->telephone) || !empty($this->request->portable)) {
            $params = ["TELEPHONE" => $this->request->telephone, "PORTABLE" => $this->request->portable];
            if ($this->Personnel->update($params, ["USER" => $iduser])) {
                //Rediriger sur ma fiche pour voir que la modif est a jour
                header("Location:" . Router::url("personnel"));
            }
        }
        $pers = $this->Personnel->findBy(["USER" => $iduser]);
        $portable = $pers[0]["PORTABLE"];
        $tel = $pers[0]["TELEPHONE"];
        $view->Assign("tel", $tel);
        $view->Assign("portable", $portable);

        $content = $view->Render("user" . DS . "telephone", false);
        $this->Assign("content", $content);
    }

    public function fiche() {
        $this->Assign("content", (new View())->output());
    }

    /**
     * Ajax utiliser dans la page index de user
     */
    public function ajax() {
        //Envoyer les infos de l'utilisateur
        $user = $this->User->findSingleRowBy(["IDUSER" => $this->request->iduser]);
        $view = new View();

        $data = $this->User->mesConnexions($user["LOGIN"]);
        $grid = new Grid($data, 0);

        $grid->addcolonne(0, "IDCONNEXION", "IDCONNEXION", false);
        $grid->addcolonne(1, "Date de début", "DATEDEBUT");
        $grid->addcolonne(2, "Machine", "MACHINESOURCE");
        $grid->addcolonne(3, "Adresse", "IPSOURCE");
        $grid->addcolonne(4, "Connexion", "CONNEXION");
        $grid->addcolonne(5, "Date de fin", "DATEFIN");
        $grid->addcolonne(6, "Déconnexion", "DECONNEXION");
        $grid->setColDate(1);
        $grid->setColDate(5);
        $grid->actionbutton = true;
        $grid->deletebutton = true;
        $grid->editbutton = false;
        $total = count($data);
        $view->Assign("connexions", $grid->display());
        //Droit de l'utilisateur
        $this->loadModel("droit");
        $droits = $this->Droit->selectAll();
        $mesdroits = json_decode($user["DROITSPECIFIQUE"]);
        $view->Assign("droits", $droits);
        $view->Assign("mesdroits", $mesdroits);

        /*
         * Variables de l'onglet 1
         */
        $view->Assign("login", $user['LOGIN']);
        $this->loadModel("profile");
        $profile = $this->Profile->findSingleRowBy(["IDPROFILE" => $user['PROFILE']]);
        $view->Assign("profile", $profile['PROFILE']);
        $view->Assign("actif", ($user['ACTIF'] == 1) ? 'Actif' : 'Non Actif' );
        //information du personnel
        $this->loadModel("personnel");
        $pers = $this->Personnel->findSingleRowBy(["USER" => $this->request->iduser]);
        $view->Assign("idpersonnel", $pers['IDPERSONNEL']);
        $view->Assign("civilite", $pers['CIVILITE']);
        $view->Assign("nom", $pers['NOM']);
        $view->Assign("prenom", $pers['PRENOM']);
        $view->Assign("autrenom", $pers['AUTRENOM']);
        $this->loadModel("fonction");
        $fonction = $this->Fonction->findSingleRowBy(["IDFONCTION" => $pers['FONCTION']]);
        $view->Assign("fonction", $fonction['LIBELLE']);
        $view->Assign("grade", $pers['GRADE']);
        $view->Assign("datenaiss", $pers['DATENAISS']);
        $view->Assign("portable", $pers['PORTABLE']);
        $view->Assign("telephone", $pers['TELEPHONE']);
        $view->Assign("email", $pers['EMAIL']);
        $arr = array();
        $arr[0] = $view->Render("user" . DS . "ajax" . DS . "onglet1", false);
        $arr[1] = $view->Render("user" . DS . "ajax" . DS . "onglet2", false);
        $arr[2] = $view->Render("user" . DS . "ajax" . DS . "onglet3", false);
        $arr[3] = $total;

        echo json_encode($arr);
    }
    /**
     * Attribution des droits par profile
     */
    public function profile(){
        if(!isAuth(609)){
            return;
        }
        if(!empty($this->request->profile)){
            $profile = $this->request->profile;
            $droits = json_encode($_POST['droits']);

            # Mettre a jour le nouveau droit du profil
            $this->Profile->update(["LISTEDROIT" => $droits], ["IDPROFILE" => $profile]);
            
            # Pour chaque utilisateur, mettre a jour la sa liste de droit specifique
            $array_of_users = $_POST['usersprofile'];
            foreach($array_of_users as $u){
                  $this->User->update(["DROITSPECIFIQUE" => $droits], ["IDUSER" => $u]);
}
        }
        $this->view->clientsJS("user" . DS . "profile");
        $view = new View();
        
        $personnels = $this->Personnel->selectAll();
        $view->Assign("personnels", $personnels);
        $droits = $this->Droit->selectAll();
        $view->Assign("droits", $droits);
        
        $profiles = $this->Profile->selectAll();
        $comboProfiles = new Combobox($profiles, "comboProfiles", $this->Profile->getKey(), $this->Profile->getLibelle());
        $comboProfiles->first = " ";
        $view->Assign("comboProfiles", $comboProfiles->view());
        $content = $view->Render("user" . DS . "profile", false);
        $this->Assign("content", $content);
    }
    
    public function ajaxprofile(){
        $view = new View();
        $json = array();
        $action = $this->request->action;
        switch ($action) {
            case "chargerDroits":
                
                $usersprofile = $this->User->findByProfile($this->request->profile);
                $view->Assign("usersprofile", $usersprofile);
                $json[0] = $view->Render("user" . DS . "ajax" . DS . "listeusersprofile", false);
                
                # Obtenir tous les droits
                 $droits = $this->Droit->selectAll();
                 $view->Assign("droits", $droits);
                 
                $droitsprofile = $this->Profile->get($this->request->profile)["LISTEDROIT"];
                $view->Assign("droitsprofile", json_decode($droitsprofile));
                $json[1] = $view->Render("user" . DS . "ajax" . DS . "listedroitsprofile", false);
                break;
            default:
                break;
        }
        echo json_encode($json);
    }
}
