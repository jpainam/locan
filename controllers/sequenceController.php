<?php

class sequenceController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("notation");
        $this->loadModel("bulletin");
        $this->loadModel("appel");
        $this->loadModel("sequence");
        $this->loadModel("recapitulatif");
        $this->loadModel("classe");
        $this->loadModel("recapitulatifbulletin");
        $this->loadModel("classeverrouillage");
    }

    public function index() {
        
    }

    public function verrouillage() {
        $this->view->clientsJS("sequence" . DS . "verrouillage");
        $view = new View();
        $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
        $view->Assign("sequences", $sequences);
        $tableSequences = $view->Render("sequence" . DS . "ajax" . DS . "tableSequence", false);
        $view->Assign("tableSequences", $tableSequences);
        $content = $view->Render("sequence" . DS . "verrouillage", false);
        $this->Assign("content", $content);
    }

    public function ajaxverrouillage() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "verrouiller":
                $this->Sequence->update(["VERROUILLER" => 1], ["IDSEQUENCE" => $this->request->idsequence]);
                # Verrouiller egalement toutes les notes dans la table notation de ce semestre
                $this->Notation->update(["VERROUILLER" => 1], ["SEQUENCE" => $this->request->idsequence]);

                # Verrouiller les appels de cette sequence
                $sequence = $this->Sequence->get($this->request->idsequence);
                $this->Appel->lockAppelsByPeriode($sequence['DATEDEBUT'], $sequence['DATEFIN']);

                # Inserer dans la BD, un resume des bulletins de la sequence
                $this->Classeverrouillage->deleteBy(["sequence" => $this->request->idsequence]);
                #$this->Recapitulatifbulletin->deleteBy(["sequence" => $this->request->idsequence]);
                #$this->recapitulerMoyenne($this->request->idsequence);
                $classes = $this->Classe->selectAll();
                foreach ($classes as $classe) {
                    $this->Classeverrouillage->insert(["sequence" => $this->request->idsequence, "classe" => $classe['IDCLASSE']]);
                }
                break;
            case "deverrouiller":
                $this->Sequence->update(["VERROUILLER" => 0], ["IDSEQUENCE" => $this->request->idsequence]);
                # Deverrouiller egalement les notes de ce semestre
                $this->Notation->update(['VERROUILLER' => 0], ["SEQUENCE" => $this->request->idsequence]);

                # Deverrouiller les appels de cette sequences
                $sequence = $this->Sequence->get($this->request->idsequence);
                $this->Appel->unlockAppelsByPeriode($sequence['DATEDEBUT'], $sequence['DATEFIN']);

                # Supprimer le resume des bulletins precedement defini lors du verrouillage
                #$this->Recapitulatifbulletin->deleteBy(["sequence" => $this->request->idsequence]);
                $this->Classeverrouillage->deleteBy(["sequence" => $this->request->idsequence]);
                break;
        }
        $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
        $view->Assign("sequences", $sequences);
        $json[0] = $view->Render("sequence" . DS . "ajax" . DS . "tableSequence", false);
        echo json_encode($json);
    }

    public function recapitulerMoyenne($idsequence) {
        # eleve, classe, sequence, moyenne, rang
        $classes = $this->Classe->selectAll();
        foreach ($classes as $classe) {

            $this->Classeverrouillage->insert(["sequence" => $idsequence, "classe" => $classe['IDCLASSE']]);
                $this->Bulletin->createTMPNoteTable($classe['IDCLASSE'], $idsequence);

                # Obtenir les moyennes de classe, la moyenne max et la moyenne min
                $moyennes = $this->Bulletin->getGlobalMoyenne();
                $params = ["classe" => $classe['IDCLASSE'],
                    "sequence" => $idsequence,
                    "moyclasse" => $moyennes['MOYCLASSE'],
                    "moymin" => $moyennes['MOYMIN'],
                    "moymax" => $moyennes['MOYMAX']];
                $this->Recapitulatifbulletin->insert($params);
                $idrecapitulatifbulletin = $this->Recapitulatifbulletin->lastInsertId();

                # Obtenir le rang des eleves
                $rangs = $this->Bulletin->getElevesRang();
                foreach ($rangs as $rang) {
                    $params = ["recapitulatifbulletin" => $idrecapitulatifbulletin,
                        "eleve" => $rang['IDELEVE'],
                        "moyenne" => $rang['MOYGENERALE'],
                        "rang" => $rang['RANG']];
                    $this->Recapitulatif->insert($params);
                }
            # Supprimer cette table
            $this->Bulletin->dropTMPNoteTable();
        }
    }

}
