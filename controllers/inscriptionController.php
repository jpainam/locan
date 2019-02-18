<?php

class inscriptionController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("note");
    }

    public function delete($id) {
        $inscription = $this->Inscription->findSingleRowBy(["IDINSCRIPTION" => $id]);
        $idclasse = $inscription['IDCLASSE'];
        if ($this->Inscription->delete($id)) {
            # Supprimer les notes qu'il a eu lorsqu'il etai inscrit dans
            # cette classe
            /*$this->Note->deleteNoteByDesinscription($inscription['ANNEEACADEMIQUE'], 
                    $inscription['IDELEVE']);*/
            $json = array();
            $elevesinscrits = $this->Inscription->getInscrits($idclasse, $this->session->anneeacademique);
            $view = new View();
            $view->Assign("eleves", $elevesinscrits);
            $json[0] = $view->Render("classe" . DS . "ajax" . DS . "eleve", false);
            //Liste des eleves non inscrits mis a jour
            $elevesnoninscripts = $this->Inscription->getNonInscrits($this->session->anneeacademique);
            $comboEleve = new Combobox($elevesnoninscripts, "listeeleve", "IDELEVE", "CNOM");
            $view->Assign("comboEleves", $comboEleve->view());
            $json[1] = $view->Render("classe" . DS . "ajax" . DS . "dialog-1", false);
        } else {
            $json[0] = "Erreur de suppression";
            $json[1] = new Combobox(NULL, "listeeleve", "IDELEVE", "CNOM");
        }
        echo json_encode($json);
    }

}
