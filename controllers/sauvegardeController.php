<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SauvegardeController
 *
 * @author JP
 */
class sauvegardeController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("sauvegarde");
    }

    public function index() {
        $view = new View();
        $this->view->clientsJS("sauvegarde" . DS . "sauvegarde");
        $sauvegardes = $this->Sauvegarde->selectAll();
        $view->Assign("sauvegardes", $sauvegardes);
        $content = $view->Render("sauvegarde" . DS . "sauvegarder", false);
        $this->Assign("content", $content);
    }

    public function telecharger($idsauvegarde) {
        $view = new View();
        $sauvegarde = $this->Sauvegarde->get($idsauvegarde);
        $view->Assign("lien", $sauvegarde['LIEN']);
        $content = $view->Render("sauvegarde" . DS . "telecharger", false);
        $this->Assign("content", $content);
    }

    public function ajaxSauvegarde() {
        $action = $this->request->action;
        $view = new View();
        $info = "";
        switch ($action) {
            case "nouvelle":
                $chemin = $this->backupDB();
                $d = new DateFR("now");
                $params = ["DESCRIPTION" => "",
                    "LIEN" => $chemin,
                    "TAILLE" => filesize($chemin),
                    "DATESAUVEGARDE" => date("Y-m-d H:i:s", time())];
                $this->Sauvegarde->insert($params);
                $info = "Sauvegarde effectu&eacute;e avec succ&egrave;s";
                break;
            case "supprimer":
                $sauve = $this->Sauvegarde->get($this->request->idsauvegarde);
                if (file_exists($sauve["LIEN"])) {
                    unlink($sauve["LIEN"]) or die("Impossible de supprimer le fichier sauvegarde " . $sauve["LIEN"]);
                }
                $this->Sauvegarde->delete($this->request->idsauvegarde);
                $info = "Sauvegarde supprim&eacute;e avec succ&egrave;s";
                break;
            case "restaurer":
                $sauve = $this->Sauvegarde->get($this->request->idsauvegarde);
                $bdPassword = "-p" . DB_PASSWORD;
                if (empty(DB_PASSWORD)) {
                    $restoreexe = "mysql -u root " . DB_NAME . " < " . $sauve['LIEN'];
                } else {
                    $restoreexe = "mysql -u root " . $bdPassword . " " . DB_NAME . " < " . $sauve['LIEN'];
                }
                exec($restoreexe);
                $info = "Restauration effectu&eacute;e avec succ&egrave;s";
                break;
        }
        $view->Assign("info", $info);
        $sauvegardes = $this->Sauvegarde->selectAll();
        $view->Assign("sauvegardes", $sauvegardes);
        echo $view->Render("sauvegarde" . DS . "ajax" . DS . "sauvegarde", false);
    }

    public function backupDB() {
        //date_default_timezone_set('Africa/Douala');
        //$date = new DateTime();
        # Obtenir la liste des host qui doivent contenir des backup
        # $this->loadModel("machine");
        # $hosts = $this->Machine->selectAll();
        # foreach ($hosts as $host) {
        #  $path = DS . DS . $host['IPADRESSE'] . DS . BACKUP_PATH;
        $path = ROOT . DS . "backups";
        //$log = $path . DS . $date->format('Y-m-d') . ".sql";

        $log = $path . DS . date("Y-m-d_\a_H\hi", time()) . ".sql";
        # $log = str_replace(":", "-", $log);
        # $log = str_replace(" ", "#", $log);

        /* if (!is_dir($path)) {
          if (mkdir($this->path, 0777) !== true) {
          die("Erreur de creation du dossier de Backup dans " . $host);
          }
          } */
        if (file_exists($log)) {
            unlink($log) or die("Impossible de supprimer l'ancien fichier sauvegarde");
        }
        //$fh = fopen($log, 'w') or die("Erreur fatale !");
        #$backupexe = "mysqldump -u root -pF3MHtpmpZ63UaZWV -h 192.168.1.3 ". DB_NAME . " > $log";
        $bdPassword = "-p" . DB_PASSWORD;
        if (empty(DB_PASSWORD)) {
            $backupexe = "mysqldump -u root -h 127.0.0.1 " . DB_NAME . " > " . $log;
        } else {
            $backupexe = "mysqldump -u root " . $bdPassword . " " . DB_NAME . " > " . $log;
        }
        exec($backupexe);
        //$backupcontent = fwrite($fh, $logcontent);
        //fclose($fh);
        # }
        return $log;
    }

}
