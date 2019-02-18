<?php

class matiereController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
         if (!isAuth(209)) {
            return;
        }
        $this->view->clientsJS("matiere" . DS . "index");
        $matieres = $this->Matiere->selectAll();
        /* $this->Assign("content", (new View())->output(
          array('matieres' => $matieres,
          'errors' => false), false)); */

        $grid = new Grid($matieres, 0);
        $grid->addcolonne(0, 'IDMATIERE', 'IDMATIERE', false);
        $grid->addcolonne(1, 'Code', 'CODE', TRUE);
        $grid->addcolonne(2, 'Libell&eacute;', 'LIBELLE', TRUE);
        
        $grid->droitdelete = 515;
        $grid->droitedit = 514;
        
        $grid->editbutton = true;
        $grid->dataTable = "tableMatieres";
        $grid->editbuttontext = "Editer";
        $grid->deletebutton = true;
        $grid->deletebuttontext = "Supprimer";
        $grid->selectbutton = false;
        $total = count($matieres);

        $this->Assign("content", (new View())->output(array(
                    "matieres" => $grid->display(),
                    "errors" => false,
                    "total" => $total), false));
    }

    /**
     * CODEDROIT : 504
     */
    public function saisie() {
        if (!isAuth(504)) {
            return;
        }
        $this->view->clientsJS("matiere" . DS . "matiere");
        $view = new View();
        $view->Assign('errors', false);

        if (!empty($this->request->code) && !empty($this->request->libelle)) {
            $params = [
                "code" => $this->request->code,
                "libelle" => $this->request->libelle,
                "bulletin" => $this->request->libelle
            ];
          
            if ($this->Matiere->insert($params)) {
                header("Location:" . url('matiere'));
            } else {
                $view->Assign("errors", true);
            }
        }
        $content = $view->Render("matiere" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function delete($id) {
        if ($this->Matiere->delete($id)) {
            header("Location:" . url('matiere'));
        } else {
            $this->Assign("content", (new View())->output(array("errors" => true), false));
        }
    }

    public function edit($id) {
        $view = new View();
        $view->Assign("errors", false);
        if (!empty($this->request->idmatiere)) {
            $params = ["CODE" => $this->request->code, "LIBELLE" => $this->request->libelle,
                "BULLETIN" => $this->request->libelle];
            if ($this->Matiere->update($params, ["IDMATIERE" => $id])) {
                header("Location:" . Router::url("matiere"));
            } else {
                $view->Assign("errors", true);
            }
        }

        $mat = $this->Matiere->getBy(["IDMATIERE" => $id]);
        $view->Assign("idmatiere", $id);
        $view->Assign("code", $mat['CODE']);
        $view->Assign("libelle", $mat['LIBELLE']);

        $content = $view->Render("matiere" . DS . "edit", false);
        $this->Assign("content", $content);
    }
    
    public function imprimer() {
        parent::printable();

        $view = new View();
        $view->Assign("pdf", $this->pdf);
        $action = $this->request->code;
        switch ($action) {
            case "0001":
                $matieres = $this->Matiere->selectAll();
                $view->Assign("matieres", $matieres);
                echo $view->Render("matiere" . DS . "impression" . DS . "listematieres", false);
                break;
        }
    }

}
