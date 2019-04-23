<?php

/**
 * 307 : Envoi de SMS
 * 308 : Suivi de SMS
 */
class notificationController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("repertoire");
        $this->loadModel("personnel");
        $this->loadModel("classe");
        $this->loadModel("responsableeleve");
        $this->loadModel("messageeleve");
        $this->loadModel("message");
        $this->loadModel("inscription");
        $this->loadModel("eleve");
    }

    public function suivi() {
        if (!isAuth(308)) {
            return;
        }
        $this->view->clientsJS("notification" . DS . "suivi");
        $view = new View();
        $destinataires = $this->Repertoire->getDestinataires();
        $comboDestinataires = new Combobox($destinataires, "comboDestinataires", "PORTABLE", ["NOM", "PORTABLE"]);
        $comboDestinataires->first = "Tous les destinataires";
        $view->Assign("comboDestinataires", $comboDestinataires->view());

        $messages = $this->Notification->selectAll();
        $view->Assign("messages", $messages);
        $tableMessages = $view->Render("notification" . DS . "ajax" . DS . "suivi", false);
        $view->Assign("tableMessages", $tableMessages);
        $content = $view->Render("notification" . DS . "suivi", false);
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
        $json[0] = $view->Render("notification" . DS . "ajax" . DS . "suivi", false);
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

        $content = $view->Render("notification" . DS . "envoi", false);
        $this->Assign("content", $content);
    }

    public function envoiIndividuel() {
        if (!empty($this->request->message)) {
            # Envoyer le SMS et rediriger vers la page de suivi de SMS
            $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
            $phone_number = $this->request->destinataire;
            $message = $this->request->message;
            $params = array(
                "dateenvoi" => date("Y-m-d H:i:s", time()),
                "destinataire" => $phone_number,
                "expediteur" => $personnel['IDPERSONNEL'],
                "message" => $message
            );
            $this->send_notification($phone_number, $message);
            $this->Notification->insert($params);
        }
    }

    private function send_notification($phone_number, $message) {
        $url = REMOTE_SERVER . "message.php";
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_HEADER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_POST => true,
            //CURLOPT_CONNECTTIMEOUT => 0
            CURLOPT_POSTFIELDS => array(
                "phone_number" => $phone_number,
                "message" => $message
            )
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function envoiParclasse() {
        $this->loadModel("inscription");
        if (!empty($this->request->messageparclasse)) {
            $message = $this->request->messageparclasse;
             $params = array(
                "dateenvoi" => date("Y-m-d H:i:s", time()),
                "expediteur" => $this->getConnectedUser()["IDPERSONNEL"],
                "message" => $message
            );
            # Get an unique parent if both have numsms
            $eleves = $this->Inscription->getInscrits($this->request->parclasse, $this->session->anneeacademique);
            foreach($eleves as $el){
                $responsables = $this->Eleve->getResponsables($el['IDELEVE']);
                foreach ($responsables as $resp) {
                    if (!empty($resp['NUMSMS'])) {
                        $params["destinataire"] = $resp['NUMSMS'];
                        $this->Notification->insert($params);
                        $this->send_notification($resp['NUMSMS'], $message);
                    }
                 }
            }
        }
        header("Location:" . Router::url("notification", "suivi"));
    }

    public function envoiCollectif() {
        if (!empty($this->request->messagecollectif)) {
            # Envoyer le SMS et rediriger vers la page de suivi de SMS
            $parents = $this->Responsableeleve->getResponsablesForCurrentStudent($this->session->anneeacademique);
            foreach ($parents as $parent) {
                if (!empty($parent["NUMSMS"])) {
                    $this->send_notification($parent['NUMSMS'], $this->request->messagecollectif);
                    # Inserer dans la table message envoyes
                    $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
                    $params = [
                        "dateenvoi" => date("Y-m-d H:i:s", time()),
                        "destinataire" => $parent["NUMSMS"],
                        "expediteur" => $personnel['IDPERSONNEL'],
                        "message" => $this->request->messagecollectif
                    ];
                    $this->Notification->insert($params);
                }
            }
        }
        //header("Location:" . Router::url("notification", "suivi"));
    }

}
