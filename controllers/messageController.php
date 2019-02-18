<?php

/**
 * 307 : Envoi de SMS
 * 308 : Suivi de SMS
 */
class messageController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("repertoire");
        $this->loadModel("personnel");
        $this->loadModel("classe");
        $this->loadModel("messageenvoye");
        $this->loadModel("responsableeleve");
        $this->loadModel("messageeleve");
        $this->loadModel("message");
    }

    public function suivi() {
        if (!isAuth(308)) {
            return;
        }
        $this->view->clientsJS("message" . DS . "suivi");
        $view = new View();
        $destinataires = $this->Repertoire->getDestinataires();
        $comboDestinataires = new Combobox($destinataires, "comboDestinataires", "PORTABLE", ["NOM", "PORTABLE"]);
        $comboDestinataires->first = "Tous les destinataires";
        $view->Assign("comboDestinataires", $comboDestinataires->view());

        $messages = $this->Messageenvoye->selectAll();
        $view->Assign("messages", $messages);
        $tableMessages = $view->Render("message" . DS . "ajax" . DS . "suivi", false);
        $view->Assign("tableMessages", $tableMessages);
        $content = $view->Render("message" . DS . "suivi", false);
        $this->Assign("content", $content);
    }

    public function ajaxsuivi() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "supprimerMessageEnvoye":
                $this->Messageenvoye->delete($this->request->idmessage);
                $messages = $this->Messageenvoye->selectAll();
                break;
            case "filterParDestinataire":
                $destinataire = $this->request->destinataire;
                $datedebut = $this->request->datedebut;
                $datefin = $this->request->datefin;
                if (empty($destinataire) && empty($datedebut) && empty($datefin)) {
                    $messages = $this->Messageenvoye->selectAll();
                } elseif (!empty($destinataire) && empty($datedebut) && empty($datefin)) {
                    $messages = $this->Messageenvoye->findBy(["DESTINATAIRE" => $destinataire]);
                } else {
                    # Obtenir les messages par utilisateurs et pour une duree donnee
                    $messages = $this->Messageenvoye->getMessagesBy($destinataire, $datedebut, $datefin);
                }
                break;
        }
        $view->Assign("messages", $messages);
        $json[0] = $view->Render("message" . DS . "ajax" . DS . "suivi", false);
        echo json_encode($json);
    }

    public function envoi() {
        if (!isAuth(307)) {
            return;
        }
        if (!empty($this->request->message)) {
            $retval = $this->envoiIndividuel();
        } elseif (!empty($this->request->messageparclasse)) {
            $retval = $this->envoiParclasse();
        } elseif (!empty($this->request->messagecollectif)) {
            $retval = $this->envoiCollectif();
        }
        $this->view->clientsJS("message" . DS . "envoi");
        $view = new View();
        if (isset($retval)) {
            $view->Assign("errors", !$retval);
        }
        $destinataires = $this->Repertoire->getDestinataires();
        $view->Assign("destinataires", $destinataires);

        $parclasse = $this->Classe->selectAll();
        $comboParclasse = new Combobox($parclasse, "parclasse", "IDCLASSE", "NIVEAUSELECT");
        $comboParclasse->first = " ";
        $view->Assign("comboParclasse", $comboParclasse->view());

        $content = $view->Render("message" . DS . "envoi", false);
        $this->Assign("content", $content);
    }

    public function envoiIndividuel() {
        if (!empty($this->request->message)) {
            # Envoyer le SMS et rediriger vers la page de suivi de SMS
            $this->activateSMS();
            $retval = $this->send($this->request->destinataire, $this->request->message);
            if ($retval !== false) {
                # Inserer dans la table message envoyes
                $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                $params = [
                    "dateenvoie" => date("Y-m-d H:i:s", time()),
                    "destinataire" => $this->request->destinataire,
                    "expediteur" => $personnel['IDPERSONNEL'],
                    "message" => $this->request->message
                ];
                $this->Messageenvoye->insert($params);
            }
        }
        return $retval;
    }

    public function envoiParclasse() {
        $retval = true;
        if (!empty($this->request->messageparclasse)) {
            $message = $this->request->messageparclasse;
            $this->activateSMS();
            $params = ["contenu" => $message, 
                "envoyerpar" => $this->getConnectedUser()["IDPERSONNEL"],
                "dateenvoi" => date("Y-m-d H:i:s", time)];
            $this->Message->insert($params);
            $idmessage = $this->Message->lastInsertId();
            
            # Get an unique parent if both have numsms
            $parents = $this->Responsableeleve->getDistinctResponsableByClasse($this->request->parclasse);
            foreach ($parents as $parent) {
                $numero = getRespNumPhone($parent);
               
                $retval = $this->send($numero, $message);
                
                $params = ["responsable" => $parent['IDRESPONSABLE'],
                    "eleve" => $parent['IDELEVE'],
                    "message" => $idmessage,
                    "dateenvoi" => date("Y-m-d H:i:s", time()),
                    "etat" => $retval];
                $this->Messageeleve->insert($params);
                sleep(7);
            }
        }
        header("Location:".Router::url("message", "suivi"));
    }

    public function envoiCollectif() {
        $retval = true;
        if (!empty($this->request->messagecollectif)) {
            # Envoyer le SMS et rediriger vers la page de suivi de SMS
            $this->activateSMS();
            $parents = $this->Responsableeleve->selectAll();
            foreach ($parents as $parent) {
                if (!empty($parent["PORTABLE"])) {
                    $retval = $this->send($parent["PORTABLE"], $this->request->messagecollectif);
                    # Inserer dans la table message envoyes
                    $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                    $params = [
                        "dateenvoie" => date("Y-m-d H:i:s", time()),
                        "destinataire" => $this->request->destinataire,
                        "expediteur" => $personnel['IDPERSONNEL'],
                        "message" => $this->request->message
                    ];
                    $this->Messageenvoye->insert($params);
                }
            }
        }

        return $retval;
    }

}
