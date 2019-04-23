<?php

class enseignantController extends Controller {

    private $comboClasses;

    public function __construct() {
        parent::__construct();
        $this->loadModel("personnel");
        $this->loadModel("eleve");
        $this->loadModel("classe");
        $this->loadModel("absenceenseignant");
        $this->loadModel("emplois");
        $this->loadModel("enseignement");
        $this->loadModel("sequence");
        $this->loadModel("etablissement");

        $classe = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classe, "comboClasses", $this->Classe->getKey(), ["LIBELLE", "NIVEAUSELECT"]);
    }

    public function index() {
        if (!isAuth(207)) {
            return;
        }
        $this->view->clientsJS("enseignant" . DS . "index");
        $view = new View();
        # $enseignants = $this->Personnel->findBy(["FONCTION" => 1]);
        # Tous les enseignants de l'etablissement pour cette annee academique
        $enseignants = $this->Etablissement->getEnseignants($this->session->anneeacademique);
        $comboEnseignants = new Combobox($enseignants, "comboEnseignants", $this->Personnel->getKey(), ["NOM", "PRENOM"]);
        $comboEnseignants->first = " ";
        $view->Assign("comboEnseignants", $comboEnseignants->view());

        $content = $view->Render("enseignant" . DS . "index", false);
        $this->Assign("content", $content);
    }

    public function ajax() {
        $json = array();
        $view = new View();
        $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->idpersonnel]);
        $view->Assign("personnel", $personnel);

        $ens = $this->Personnel->getEnseignements($this->request->idpersonnel, $this->session->anneeacademique);
        $view->Assign("enseignements", $ens);

        $eleves = $this->Eleve->getElevesEnseignesPar($this->request->idpersonnel, $this->session->anneeacademique);
        $view->Assign("eleves", $eleves);

        $array_of_redoublants = $this->Classe->getRedoublantsByAnneeAcademique($this->session->anneeacademique, true);
        $view->Assign("array_of_redoublants", $array_of_redoublants);
        
        $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "onglet1", false);
        $json[1] = $view->Render("enseignant" . DS . "ajax" . DS . "onglet2", false);
        $json[2] = $view->Render("enseignant" . DS . "ajax" . DS . "onglet3", false);
        $this->loadModel("emplois");
        $emplois = $this->Emplois->getEmploisByEnseignant($this->request->idpersonnel);
        $view->Assign("enseignements", $emplois);
        $this->loadModel("horaire");
        $horaire = $this->Horaire->findBy(["PERIODE" => $this->session->anneeacademique]);
        $view->Assign("horaire", $horaire);
        $heure_debut = array();
        foreach ($horaire as $line){
            $heure_debut[] = substr($line["HEUREDEBUT"], 0, strlen($line["HEUREDEBUT"]) - 3);
        }
        $view->Assign("heure_debut", json_encode($heure_debut));
        $json[3] = $view->Render("enseignant" . DS . "ajax" . DS . "onglet4", false);

        echo json_encode($json);
    }

    public function appel() {
        $this->view->clientsJS("enseignant" . DS . "appel");
        $view = new View();

        $datejour = date("Y-m-d", time());
        $absences = $this->Absenceenseignant->getAbsencesDuJour($datejour);
        $view->Assign("absences", $absences);
        $appel = $view->Render("enseignant" . DS . "ajax" . DS . "appel", false);
        $view->Assign("appel", $appel);
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $legendes = $view->Render("enseignant" . DS . "legendes", false);
        $view->Assign("legendes", $legendes);

        $content = $view->Render("enseignant" . DS . "appel", false);
        $this->Assign("content", $content);
    }

    public function ajaxappel() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "ajouterAbsence":
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $idpersonnel = $this->request->idpersonnel;
                $enseignement = $this->request->idenseignement;

                if ($this->appeldeja($datedebut, $idpersonnel, $enseignement)) {
                    $json[0] = "";
                    $json[1] = true;
                } else {
                    $etat = "R";
                    $nbHeure = 0;
                    $retard = $this->request->retard . ":00";
                    if (empty($this->request->retard)) {
                        $etat = "A";
                        $nbHeure = $this->request->absence;
                        $retard = "00:00:00";
                    }
                    $params = ["datejour" => $datedebut,
                        "personnel" => $this->request->idpersonnel,
                        "enseignement" => $this->request->idenseignement,
                        "etat" => $etat,
                        "retard" => $retard,
                        "nbheure" => $nbHeure,
                        "observation" => $this->request->autres];
                    $this->Absenceenseignant->insert($params);

                    $absences = $this->Absenceenseignant->getAbsencesByPeriode($datedebut, $datefin);
                    $view->Assign("absences", $absences);
                    $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "appel", false);
                    $json[1] = false;
                }
                break;
            case "chargerEnseignants":
                $enseignants = $this->Enseignement->getPersonnelsEnseignants($this->request->idclasse);
                $view->Assign("enseignants", $enseignants);
                $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "comboEnseignant", false);
                break;
            case "chargerMatieres":
                $enseignements = $this->Enseignement->findBy(["professeur" => $this->request->idpersonnel,
                    "classe" => $this->request->idclasse]);

                $view->Assign("enseignements", $enseignements);
                $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "comboMatiere", false);
                break;
            case "supprimerAbsence":
                $this->Absenceenseignant->delete($this->request->idabsence);
            case "chargerAbsence":
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $absences = $this->Absenceenseignant->getAbsencesByPeriode($datedebut, $datefin);
                $view->Assign("absences", $absences);
                $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "appel", false);
                break;
        }
        echo json_encode($json);
    }

    public function discipline() {
        $this->view->clientsJS("enseignant" . DS . "discipline");
        $view = new View();
        $legendes = $view->Render("appel" . DS . "legendes", false);
        $view->Assign("legendes", $legendes);
        $datedebut = date("Y-m-d", time());
        $absences = $this->Absenceenseignant->getResumesByPeriode($datedebut);
        $view->Assign("absences", $absences);
        $discipline = $view->Render("enseignant" . DS . "ajax" . DS . "discipline", false);
        $view->Assign("discipline", $discipline);
        $content = $view->Render("enseignant" . DS . "discipline", false);
        $this->Assign("content", $content);
    }

    public function ajaxdiscipline() {
        $action = $this->request->action;
        $view = new View();
        $json = array();
        switch ($action) {
            case "chargerAbsences":
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
               $absences = $this->Absenceenseignant->getResumesByPeriode($datedebut, $datefin);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $view->Assign("absences", $absences);
                $json[0] = $view->Render("enseignant" . DS . "ajax" . DS . "discipline", false);

                break;
        }
        echo json_encode($json);
    }

    public function appeldeja($datejour, $personnel, $enseignement) {
        $abs = $this->Absenceenseignant->getBy([
            "datejour" => $datejour,
            "personnel" => $personnel,
            "enseignement" => $enseignement]);

        if (!empty($abs)) {
            return true;
        }
        return false;
    }

    public function imprimer() {
        parent::printable();
        $view = new View();
        $view->Assign("pdf", $this->pdf);
        switch ($this->request->code) {
            case "0001":
                $personnel = $this->Personnel->findSingleRowBy(["IDPERSONNEL" => $this->request->idpersonnel]);
                $view->Assign("personnel", $personnel);

                $ens = $this->Personnel->getEnseignements($this->request->idpersonnel);
                $view->Assign("enseignements", $ens);
                echo $view->Render("enseignant" . DS . "impression" . DS . "fiche", false);
                break;
            # Absence du jour des enseignant
            case "0002":
                $date = parseDate($this->request->datedebut);
                if (empty($date)) {
                    $date = date("Y-m-d", time());
                }
                $view->Assign("datejour", $date);
                $absences = $this->Absenceenseignant->getAbsencesDuJour($date);
                $view->Assign("absences", $absences);
                $classes = $this->Classe->selectAll();
                $view->Assign("classes", $classes);
                $sequence = $this->Sequence->getSequenceByDate($date);
                $view->Assign("sequence", $sequence);
                echo $view->Render("enseignant" . DS . "impression" . DS . "absencejour", false);
                break;
            case "0003":
                # Impression synthese hebdo des absences
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $absences = $this->Absenceenseignant->getAbsencesByPeriode($datedebut, $datefin);
                $view->Assign("absences", $absences);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $sequence = $this->Sequence->getSequenceByDate($datedebut);
                $view->Assign("sequence", $sequence);
                echo $view->Render("enseignant" . DS . "impression" . DS . "absencesemaine", false);
                break;
            case "0004":
                # Impression synthese hebdo des absences
                echo $view->Render("enseignant" . DS . "impression" . DS . "systhesehebdo", false);
                break;
            case "0005":
                $this->pdf->isLandscape = true;
                $this->pdf->bCertify = false;
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $sequence = $this->Sequence->getSequenceByDate($datedebut);
                $view->Assign("sequence", $sequence);
                echo $view->Render("enseignant" . DS . "impression" . DS . "suividisciplinairevierge", false);
                break;
            case "0006":
                $this->pdf->isLandscape = true;
                $this->pdf->bCertify = false;
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $sequence = $this->Sequence->getSequenceByDate($datedebut);
                $view->Assign("sequence", $sequence);
                $absences = $this->Absenceenseignant->getAbsencesByPeriode($datedebut, $datefin);
                $view->Assign("absences", $absences);
                echo $view->Render("enseignant" . DS . "impression" . DS . "suividisciplinaire", false);
                break;
            # Recapitulatif des absences des enseignants
            case "0007":
                  
                $datedebut = parseDate($this->request->datedebut);
                $datefin = parseDate($this->request->datefin);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $absences = $this->Absenceenseignant->getResumesByPeriode($datedebut, $datefin);
                
                $view->Assign("absences", $absences);
                echo $view->Render("enseignant" . DS . "impression" . DS . "recapitulatifabsence", false);
                break;
            # Recapitulatif d'absence par enseignant
            case "0008":
             
                $datedebut = parseDate($this->request->datedebut);
                if(empty($datedebut)){
                    $datedebut = date("Y-m-d", time());
                }
                $datefin = parseDate($this->request->datefin);
                $view->Assign("datedebut", $datedebut);
                $view->Assign("datefin", $datefin);
                $absences = $this->Absenceenseignant->getAbsencesByEnseignant($this->request->idpersonnel, $datedebut, $datefin);
                $view->Assign("absences", $absences);
                $enseignant = $this->Personnel->get($this->request->idpersonnel);
                $view->Assign("enseignant", $enseignant);
                
                $recapitulatif = $this->Absenceenseignant->getResumesByPeriodeByEnseignant($this->request->idpersonnel,
                        $datedebut, $datefin);
                $view->Assign("recapitulatif", $recapitulatif);
                echo $view->Render("enseignant" . DS . "impression" . DS . "recapitulatifindividuelle", false);
                break;
             # Repertoire telephonique des enseignants
            case "0009":
                # Tous les enseignants de l'etablissement pour cette annee academique
                $enseignants = $this->Etablissement->getEnseignants($this->session->anneeacademique);
                $view->Assign("enseignants", $enseignants);
                echo $view->Render("enseignant" . DS . "impression" . DS . "repertoiretelephonique", false);
                break;
            case "0010":
                # Imprimer l'emploi du temps pour une classe
                $this->loadModel("emplois");
                $emplois = $this->Emplois->getEmploisByEnseignant($this->request->idpersonnel);
                $prof = $this->Personnel->get($this->request->idpersonnel);
                $view->Assign("prof", $prof);
                $view->Assign("enseignements", $emplois);
                $this->loadModel("horaire");
                $horaires = $this->Horaire->findBy(["PERIODE" => $this->session->anneeacademique]);
                $view->Assign("horaires", $horaires);     
                echo $view->Render("enseignant" . DS . "impression" . DS . "emploisdutemps", false);
                break;
        }
    }

}
