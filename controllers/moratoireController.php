<?php

class moratoireController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel('eleve');
        $this->loadModel('personnel');
        $this->loadModel('frais');
        $this->loadModel('caisse');
    }

    public function recu($idmoratoire) {
        if (!isAuth(539)) {
            return;
        }
        $this->view->clientsJS("moratoire" . DS . "recu");
        $view = new View();
        $operation = $this->Moratoire->get($idmoratoire);

        $view->Assign("operation", $operation);

 
        $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);


        $enregistreur = $this->Personnel->get($operation['ENREGISTRERPAR']);
        $view->Assign("enregistreur", $enregistreur);

        $classe = $this->Eleve->getClasse($operation['ELEVE'], $this->session->anneeacademique);
        $view->Assign("classe", $classe);
        $montantapayer = $this->Frais->getClasseTotalFrais($classe['IDCLASSE']);
        $view->Assign("montantapayer", $montantapayer);

        $montantpayer = $this->Caisse->getMontantPayer($operation['ELEVE']);
        $view->Assign("montantpayer", $montantpayer);
        $content = $view->Render("moratoire" . DS . "recu", false);
        $this->Assign("content", $content);
    }
    
     public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            # Impression du recu de caisse
            case "0001":
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                $operation = $this->Moratoire->get($this->request->idmoratoire);
                $view->Assign("operation", $operation);
                $view->Assign("personnel", $personnel);

                $enregistreur = $this->Personnel->get($operation['ENREGISTRERPAR']);
                $view->Assign("enregistreur", $enregistreur);

                $classe = $this->Eleve->getClasse($operation['ELEVE'], $this->session->anneeacademique);
                $view->Assign("classe", $classe);
                $montantapayer = $this->Frais->getClasseTotalFrais($classe['IDCLASSE']);
                $view->Assign("montantapayer", $montantapayer);

                $montantpayer = $this->Caisse->getMontantPayer($operation['ELEVE']);
                $view->Assign("montantpayer", $montantpayer);
                echo $view->Render("moratoire" . DS . "impression" . DS . "recu", false);
                break;
           
        }
    }

}
