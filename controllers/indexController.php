<?php

class IndexController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($sent = "") {
        $view = new View();
        if (!empty($sent) && $sent === "notsent") {
            $view->Assign("errors", TRUE);
        } elseif (!empty($sent) && $sent === "sent") {
            $view->Assign("errors", false);
        }
        $str = "Utilisateur connect&eacute; : " . $_SESSION['user'] .
                "/" . $_SESSION['profile'] . "/IPW " . $_SESSION['anneeacademique'];
        $view->Assign("infos", $str);
        $view->Assign("school", $this->school);

        $content = $view->Render("index" . DS . "index", false);



        $this->Assign("content", $content);
    }

    /**
      Methode a argument variable
     */
    public function methode($query1 = "", $query2 = "") {
        echo $query1 . " " . $query2;
    }

    public function envoyer() {
        if ($this->activateSMS()) {
            $this->send(NUM_CONCEPTEUR, "Message envoye depuis le system de IPW");
            header("Location:" . Router::url("index", "index", "sent"));
        } else {
            header("Location:" . Router::url("index", "index", "notsent"));
        }
    }

    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        echo $view->Render("index" . DS . "impression" . DS . "font", false);
    }

}
