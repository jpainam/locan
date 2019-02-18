<?php
/**
 * 511 : Modification des frais
 * 510 : Suppression des frais
 */
class fraisController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
    }

    public function index() {
        if (!isAuth(211)) {
            return;
        }
        $this->view->clientsJS("frais" . DS . "index");
        $view = new View();
        $frais = $this->Frais->getFrais($this->session->anneeacademique);
        $grid = new Grid($frais, 0);
        $grid->addcolonne(0, "IDFRAIS", "IDFRAIS", false);
        $grid->addcolonne(1, "Classe", "LIBELLE");
		$grid->addcolonne(2, "Niveau", "NIVEAUHTML");
        $grid->addcolonne(3, "Description du frais", "DESCRIPTION");
        $grid->addcolonne(4, "Montant", "MONTANT");
        $grid->addcolonne(5, "Ech&eacute;ances", "ECHEANCES");
        $grid->dataTable = "fraisTable";

        $grid->actionbutton = true;
        $grid->deletebutton = true;
        $grid->droitdelete = 510;
        $grid->droitedit = 511;
		$grid->setColDate(5);
        $view->Assign("frais", $grid->display());
        $content = $view->Render("frais" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function delete($id) {
        $this->Frais->delete($id);
        header("Location:" . Router::url("frais"));
    }

    function saisie() {
        if (!isAuth(509)) {
            return;
        }
        $this->view->clientsJS("frais" . DS . "frais");
        $view = new View();

        $data = $this->Classe->findBy(["ANNEEACADEMIQUE" => $this->session->anneeacademique]);
        $comboClasses = new Combobox($data, "comboClasses", "IDCLASSE", ["LIBELLE", "NIVEAUSELECT"]);
        $comboClasses->first = " ";
        $view->Assign("comboClasses", $comboClasses->view());
        $content = $view->Render("frais" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    function ajax($action) {
        $view = new View();
        $json = array();
        switch ($action) {
            case "ajouter":
                $params = ["DESCRIPTION" => $this->request->description, "MONTANT" => $this->request->montant,
                    "ECHEANCES" => $this->request->echeances, "CLASSE" => $this->request->idclasse];
                $this->Frais->insert($params);
                break;
            case "supprimer":
                $this->Frais->delete($this->request->idfrais);
                break;
            case "load":
                break;
            case "edit":
                $params = ["DESCRIPTION" => $this->request->description, "CLASSE" => $this->request->idclasse,
                    "ECHEANCES" => $this->request->echeances, "MONTANT" => $this->request->montant];
                $this->Frais->update($params, ["IDFRAIS" => $this->request->idfrais]);
                break;
        }
        $frais = $this->Frais->findBy(["CLASSE" => $this->request->idclasse]);
        $view->Assign("frais", $frais);
        $json[0] = $view->Render("frais" . DS . "ajax" . DS . "frais", false);
        echo json_encode($json);
    }

}
