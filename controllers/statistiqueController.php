<?php

class statistiqueController extends Controller {

    public function __construct() {
        parent::__construct();

        $this->loadModel("matiere");
        $this->loadModel("anneeacademique");
        $this->loadModel("sequence");
        $this->loadModel("trimestre");
        $this->loadModel("enseignement");
        $this->loadModel("classe");
        $this->loadModel("bulletin");
        $this->loadModel("eleve");
        $this->loadModel("absenceperiodique");
        $this->loadModel("inscription");

        $periodes = $this->Anneeacademique->getPeriodes($this->session->anneeacademique);
        $this->comboPeriodes = new Combobox($periodes, "comboPeriodes", "IDPERIODE", "LIBELLE");
        $this->comboPeriodes->first = " ";
    }

    public function couverture() {
        $this->view->clientsJS("statistique" . DS . "couverture");
        $view = new View();
        $matieres = $this->Matiere->selectAll();
        $comboMatieres = new Combobox($matieres, "comboMatieres", $this->Matiere->getKey(), $this->Matiere->getLibelle());
        $comboMatieres->first = " ";

        $view->Assign("comboMatieres", $comboMatieres->view());
        $content = $view->Render("statistique" . DS . "couverture", false);
        $this->Assign("content", $content);
    }

    public function bilan() {
        $this->view->clientsJS("statistique" . DS . "bilan");
        $view = new View();
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("statistique" . DS . "bilan", false);
        $this->Assign("content", $content);
    }

    public function ajaxbilan() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "chargerDistribution":
                $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
                $view->Assign("periode", $this->request->periode);
                $view->Assign("sequences", $sequences);
                $view->Assign("anneeacademique", $this->session->anneeacademique);

                $trimestres = $this->Trimestre->findBy(["PERIODE" => $this->session->anneeacademique]);
                $view->Assign("trimestres", $trimestres);

                $annee = $this->Anneeacademique->selectAll();
                $view->Assign("annee", $annee);

                $json[0] = $view->Render("appel" . DS . "ajax" . DS . "comboDistribution", false);
                break;
        }
        echo json_encode($json);
    }

    public function imprimer() {
        ob_start();
        parent::printable();

        $code = $this->request->code;
        $view = new View();
        $view->Assign("pdf", $this->pdf);

        switch ($code) {
            # Impression du taux de couverture des programmes et heures
            case "0001":
                $this->pdf->isLandscape = true;
                echo $view->Render("statistique" . DS . "impression" . DS . "couverture", false);
                break;
            case "0002":
                # Impression du bilan global des resultats
                echo $view->Render("statistique" . DS . "impression" . DS . "bilanresultat", false);
                break;
            case "0005":
                $this->getBilanGlobal($view);
                echo $view->Render("statistique" . DS . "impression" . DS . "bilanresultat");
                break;
        }
        echo ob_get_contents();
        ob_end_flush();
    }

    public function getBilanGlobal(&$view) {
        $codeperiode = substr($this->request->periode, 0, 1);
        # Recuperer l'id de la periode
        $pos = strrpos($this->request->periode, "_");
        $idperiode = substr($this->request->periode, $pos + 1);
        if ($codeperiode === "S") {
            $sequence = $this->Sequence->get($idperiode);
            $view->Assign("sequence", $sequence);
            $absences = $this->Absenceperiodique->findBy(["SEQUENCE" => $idperiode]);
        } elseif ($codeperiode === "T") {
            $trimestre = $this->Trimestre->get($idperiode);
            $view->Assign("trimestre", $trimestre);
            $sequences = $this->Sequence->findBy(['TRIMESTRE' => $idperiode]);
            $array_of_sequences = [$sequences[0]['IDSEQUENCE'], $sequences[1]['IDSEQUENCE']];
            $absences = $this->Absenceperiodique->getAbsenceGlobalTrimestre($array_of_sequences);
        }
        $classes = $this->Classe->selectAll();
        $bilan = array();
        $array_of_classes = array();
        foreach ($classes as $cl) {
            if ($codeperiode === "S") {
                $this->Bulletin->createTMPNoteTable($cl['IDCLASSE'], $idperiode);
            } elseif ($codeperiode === "T") {
                $this->Bulletin->createTrimestreTable($cl['IDCLASSE'], $array_of_sequences);
            }
            $rangs = $this->Bulletin->getElevesRang();
            $bilan['rangs'] = $rangs;
            $travail = $this->Bulletin->getGlobalMoyenne();
            $bilan['travail'] = $travail;
            $array_of_classes[$cl['IDCLASSE']] = $bilan;
            $this->Bulletin->dropTMPTable();
        }
        $inscrits = $this->Inscription->getInscritParClasse();
        $view->Assign("inscrits", $inscrits);
        $view->Assign("absences", $absences);
        $view->Assign("array_of_classes", $array_of_classes);
        $view->Assign("classes", $classes);
        $view->Assign("codeperiode", $codeperiode);
    }

}
