<?php

/**
 * 407: Modification des notes
 * 401: Saisie des notes
 * 409: Suppression des notes d'eleves
 * 212: Affichage des note
 * 408: Verrouillage et deverouillage des notes
 */
class noteController extends Controller {

    private $comboClasses;
    private $comboPeriodes;

    public function __construct() {
        parent::__construct();
        $this->loadModel("classe");
        $this->loadModel("sequence");
        $this->loadModel("enseignement");
        $this->loadModel("inscription");
        $this->loadModel("notation");
        $this->loadModel("personnel");
        $this->loadModel("matiere");
        $this->loadModel("messagetype");
        $this->loadModel("eleve");
        $this->loadModel("bulletin");
        $this->loadModel("recapitulatif");
        $this->loadModel("recapitulatifbulletin");
        $this->loadModel("anneeacademique");
        $this->loadModel("trimestre");
        $this->loadModel("absenceperiodique");
        $this->loadJPGraph();

        $classes = $this->Classe->selectAll();
        $this->comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), ["LIBELLE", "NIVEAUSELECT"]);

        $periode = $this->Sequence->getSequences($this->session->anneeacademique);
        $this->comboPeriodes = new Combobox($periode, "comboPeriodes", $this->Sequence->getKey(), $this->Sequence->getLibelle());
        $this->comboPeriodes->first = " ";
    }

    public function index() {
        if (!isAuth(212)) {
            return;
        }
        $this->view->clientsJS("note" . DS . "index");
        $view = new View();
        $this->comboPeriodes->first = "Ann&eacute;e acad&eacute;mique";
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $classes = $this->Classe->selectAll();
        $comboClasses = new Combobox($classes, "comboClasses", $this->Classe->getKey(), ["LIBELLE", "NIVEAUSELECT"]);
        $comboClasses->first = "Toutes";
        if (!isAuth(531)) {
            $comboClasses->disabled = true;
        }
        $view->Assign("comboClasses", $comboClasses->view());

        # $notations = $this->Notation->selectAll();
        $notations = $this->Notation->findBy(["SEQUENCE" => 1]);
        $view->Assign("notations", $notations);

        $tableNotes = $view->Render("note" . DS . "ajax" . DS . "tableNotes", false);

        $view->Assign("tableNotes", $tableNotes);
        $content = $view->Render("note" . DS . "index", false);
        $this->Assign("content", $content);
    }

    /**
     * 
     */
    public function ajaxindex() {
        $action = $this->request->action;
        $json = array();
        $json[0] = "";
        $view = new View();
        switch ($action) {
            case "notifierNotation":
                # Activer les fonctionnalites SMS
                if (!$this->activateSMS()) {
                    # Une erreur s'est produite
                    $json[1] = 0;
                } else {
                    $this->notifyNotation($this->request->idnotation);
                    $json[1] = 1;
                }
            case "chargerNotation":
                $idclasse = $this->request->idclasse;
                $idperiode = $this->request->idperiode;
                if (empty($idclasse) && empty($idperiode)) {
                    $notations = $this->Notation->selectAll();
                } elseif (empty($idclasse) && !empty($idperiode)) {
                    $notations = $this->Notation->getNotationsByPeriode($idperiode);
                } elseif (!empty($idclasse) && empty($idperiode)) {
                    $notations = $this->Notation->getNotationsByClasse($idclasse);
                } else {
                    $notations = $this->Notation->getNotationsByClasseByPeriode($idclasse, $idperiode);
                }
                $view->Assign("notations", $notations);
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "tableNotes", false);
                break;
        }
        echo json_encode($json);
    }

    public function validerSaisie() {
        if (isset($this->request->deja)) {
            header("Location:" . Router::url("note"));
        }
        $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);

        $personnel = $this->Personnel->findSingleRowBy(["USER" => $this->session->iduser]);

        $datedevoir = empty($this->request->datedevoir) ? date("Y-m-d", time()) : parseDate($this->request->datedevoir);
        $params = ["enseignement" => $this->request->idenseignement,
            "description" => $this->request->description,
            "notesur" => $this->request->notesur,
            "sequence" => $this->request->sequence,
            "datejour" => date("Y-m-d", time()),
            "datedevoir" => $datedevoir,
            "realiserpar" => $personnel['IDPERSONNEL']
        ];

        $this->Notation->insert($params);
        $idnotation = $this->Notation->lastInsertId();
        foreach ($eleves as $el) {
            $note = $this->request->{"note_" . $el['IDELEVE']};
            $note = str_replace(",", ".", $note);
            $ideleve = $el['IDELEVE'];
            //1 = absent, 0 = present
            $absent = 0;
            if ($note > 20 || $note < 0) {
                $note = "";
            }
            if (empty(trim($note)) || trim($note) === "") {
                $note = NULL;
                $absent = 1;
            }

            $observation = $this->request->{"observation_" . $el['IDELEVE']};

            $params = ["note" => $note,
                "notation" => $idnotation,
                "eleve" => $ideleve,
                "absent" => $absent,
                "observation" => $observation];
            $this->Note->insert($params);
        }
        header("Location:" . Router::url("note"));
    }

    public function saisie() {
        if (!isAuth(401)) {
            return;
        }
        if (!empty($this->request->idenseignement)) {
            $this->validerSaisie();
        }
        $this->view->clientsJS("note" . DS . "note");
        $view = new View();
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("note" . DS . "saisie", false);
        $this->Assign("content", $content);
    }

    public function ajaxsaisie() {
        $view = new View();
        $json = array();
        $action = $this->request->action;
        switch ($action) {
            case "chargerMatieres":
                #$matieres = $this->Enseignement->getEnseignements($this->request->idclasse);
                $matieres = $this->Notation->getEnseignementNonNote($this->request->idclasse, $this->request->idsequence);

                $view->Assign("matieres", $matieres);
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "comboMatieres", false);
                break;
            case "chargerEleves":
                # Verifier si une saisie avait ete effectue, si oui, proposer la modification des notes
                $notes = $this->Note->findBy(["ENSEIGNEMENT" => $this->request->idenseignement,
                    "sequence" => $this->request->sequence]);
                $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                $view->Assign("eleves", $eleves);

                if (count($notes) > 0) {
                    $view->Assign("notes", $notes);
                    $view->Assign("deja", true);
                    $view->Assign("notation", $notes[0]['NOTATION']);
                } else {
                    $view->Assign("deja", false);
                }
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "listeeleves", false);

                $ens = $this->Enseignement->getBy(["IDENSEIGNEMENT" => $this->request->idenseignement]);
                $json[1] = $ens['COEFF'];

                break;
        }
        echo json_encode($json);
    }

    public function recapitulatif() {
        $view = new View();
        $this->view->clientsJS("note" . DS . "recapitulatif");
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $periodes = $this->Anneeacademique->getPeriodes($this->session->anneeacademique);
        $this->comboPeriodes = new Combobox($periodes, "comboPeriodes", "IDPERIODE", "LIBELLE");
        $this->comboPeriodes->first = " ";
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("note" . DS . "recapitulatif", false);
        $this->Assign("content", $content);
    }

    public function ajaxrecapitulatif() {
        $action = $this->request->action;
        $idclasse = $this->request->idclasse;
        $idperiode = $this->request->periode;
        $json = array();
        $view = new View();
        switch ($action) {
            case "chargerRecapitulatif":
                # S = Sequentielle, T = Trimestrielle, Autre pour annuelle
                $codeperiode = substr($idperiode, 0, 1);

                # Recuperer l'id de la periode
                $pos = strrpos($idperiode, "_");
                $idperiode = substr($idperiode, $pos + 1);
                if ($codeperiode === "S") {
                    $this->Bulletin->createTMPNoteTable($idclasse, $idperiode);
                } elseif ($codeperiode === "T") {
                    $sequences = $this->Sequence->findBy(['TRIMESTRE' => $idperiode]);
                    $array_of_sequences = [$sequences[0]['IDSEQUENCE'], $sequences[1]['IDSEQUENCE']];
                    $this->Bulletin->createTrimestreTable($idclasse, $array_of_sequences);
                } elseif ($codeperiode === "A") {
                    $sequences = $this->Sequence->getIdSequences($_SESSION['anneeacademique']);
                    $this->Bulletin->createAnnuelleTable($idclasse, $sequences);
                } else {
                    throw new Exception("CODE PERIODE INEXISTANT");
                }
                $enseignements = $this->Enseignement->getEnseignements($idclasse);
                $view->Assign("enseignements", $enseignements);
                $notes = $this->Bulletin->selectAll();
                $view->Assign("notes", $notes);
                $this->Bulletin->dropTMPNoteTable();
                $json[0] = $view->Render("note" . DS . "ajax" . DS . "recapitulatif", false);
                break;
        }
        echo json_encode($json);
    }

    public function bilan() {
        $view = new View();
        $this->view->clientsJS("note" . DS . "bilan");
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $content = $view->Render("note" . DS . "bilan", false);
        $this->Assign("content", $content);
    }

    public function edit($id) {
        if (!isAuth(407)) {
            return;
        }
        if (!empty($this->request->notation)) {
            $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
            $this->Note->deleteBy(["notation" => $this->request->notation]);
            foreach ($eleves as $el) {
                $note = 0;
                if (isset($this->request->{"note_" . $el['IDELEVE']})) {
                    $note = $this->request->{"note_" . $el['IDELEVE']};
                    $note = str_replace(",", ".", $note);
                }
                /* $idnote = "";
                  if (isset($this->request->{"id_" . $el['IDELEVE']})) {
                  $idnote = $this->request->{"id_" . $el['IDELEVE']};
                  } */
                # 1 = absent, 0 = present
                $absent = 0;
                if (isset($this->request->{"absent_" . $el['IDELEVE']}) && $this->request->{"absent_" . $el['IDELEVE']} === "on") {
                    $absent = 1;
                }
                if ($absent) {
                    $note = null;
                }
                if (isset($this->request->{"observation_" . $el['IDELEVE']})) {
                    $observation = $this->request->{"observation_" . $el['IDELEVE']};
                }
                if ($note < 0 || $note > 20) {
                    $note = null;
                    $absent = 1;
                }

                $params = ["note" => $note,
                    "absent" => $absent,
                    "observation" => $observation,
                    "eleve" => $el['IDELEVE'],
                    "notation" => $this->request->notation];
                $this->Note->insert($params);
            }
            # Mettre a jour les details de modification
            $personnel = $this->Personnel->getBy(["USER" => $this->session->iduser]);
            $params = ["modifierpar" => $personnel['IDPERSONNEL'],
                "datemodification" => date("Y-m-d", time())];
            $this->Notation->update($params, ["IDNOTATION" => $this->request->notation]);
            header("Location:" . Router::url("note"));
        }
        $this->view->clientsJS("note" . DS . "edit");
        $view = new View();
        $notes = $this->Note->findBy(["NOTATION" => $id]);
        $notation = $this->Notation->findSingleRowBy(["IDNOTATION" => $id]);
        $eleves = $this->Inscription->getInscrits($notation['CLASSE']);
        $view->Assign("eleves", $eleves);
        $view->Assign("notation", $notation);
        $view->Assign("notes", $notes);
        $content = $view->Render("note" . DS . "edit", false);
        $this->Assign("content", $content);
    }

    public function verrouillage() {
        if (!isAuth(604)) {
            return;
        }
        $this->view->clientsJS("note" . DS . "verrouillage");
        $view = new View();
        $this->comboPeriodes->first = "Ann&eacute;e acad&eacute;mique";
        $view->Assign("comboPeriodes", $this->comboPeriodes->view());

        $enseignements = $this->Enseignement->getAllEnseignements($this->session->anneeacademique);
        $comboEnseignements = new Combobox($enseignements, "comboEnseignements", $this->Enseignement->getKey(), ["MATIERELIBELLE", "CLASSELIBELLE"]);
        $comboEnseignements->first = "Toutes";
        $view->Assign("comboEnseignements", $comboEnseignements->view());

        $notations = $this->Notation->selectAll();
        $view->Assign("notations", $notations);

        $verrouillage = $view->Render("note" . DS . "ajax" . DS . "verrouillage", false);
        $view->Assign("verrouillage", $verrouillage);

        $content = $view->Render("note" . DS . "verrouillage", FALSE);
        $this->Assign("content", $content);
    }

    public function ajaxverrouillage() {
        $action = $this->request->action;
        $json = array();
        $view = new View();
        switch ($action) {
            case "verrouiller":
                $idnotation = $this->request->idnotation;
                $this->Notation->update(["VERROUILLER" => 1], ["IDNOTATION" => $idnotation]);
                break;
            case "deverrouiller":
                $idnotation = $this->request->idnotation;
                $this->Notation->update(["VERROUILLER" => 0], ["IDNOTATION" => $idnotation]);
                break;
        }
        $idens = $this->request->idenseignement;
        $idperiode = $this->request->idperiode;
        if (empty($idens) && empty($idperiode)) {
            $notations = $this->Notation->selectAll();
        } elseif (empty($idens) && !empty($idperiode)) {
            $notations = $this->Notation->findBy(["SEQUENCE" => $idperiode]);
        } elseif (!empty($idens) && empty($idperiode)) {
            $notations = $this->Notation->findBy(["ENSEIGNEMENT" => $idens]);
        } else {
            $notations = $this->Notation->findBy(["ENSEIGNEMENT" => $idens, "SEQUENCE" => $idperiode]);
        }
        $view->Assign("notations", $notations);
        $json[0] = $view->Render("note" . DS . "ajax" . DS . "verrouillage", false);
        echo json_encode($json);
    }

    public function statistique() {
        $view = new View();


        $this->view->clientsJS("note" . DS . "statistique");
        $this->comboClasses->first = " ";
        $view->Assign("comboClasses", $this->comboClasses->view());

        $matieres = $this->Matiere->selectAll();
        $comboMatieres = new Combobox($matieres, "comboMatieres", $this->Matiere->getKey(), $this->Matiere->getLibelle());
        $comboMatieres->first = " ";
        $view->Assign("comboMatieres", $comboMatieres->view());

        $sequences = $this->Sequence->getSequences($this->session->anneeacademique);
        $comboPeriode = new Combobox($sequences, "comboPeriodes", $this->Sequence->getKey(), $this->Sequence->getLibelle());
        $view->Assign("comboPeriodes", $comboPeriode->view());

        $content = $view->Render("note" . DS . "statistique", false);


        $this->Assign("content", $content);
    }

    public function report() {
        $view = new View();
        $content = $view->Render("note" . DS . "report", false);
        $this->Assign("content", $content);
    }

    public function imprimer() {
        parent::printable();

        $view = new View();
        $view->Assign("pdf", $this->pdf);
        $view->Assign("anneescolaire", $this->session->anneeacademique);

        $action = $this->request->code;
        switch ($action) {
            case "0001":
                # Fiche de report de note vierge accessible dans note/saisie
                $ens = $this->Enseignement->get($this->request->idenseignement);
                $view->Assign("enseignement", $ens);

                $view->Assign("classe", $this->Classe->get($this->request->idclasse));

                # Liste des eleves inscrit
                $eleves = $this->Inscription->getInscrits($this->request->idclasse);
                $view->Assign("eleves", $eleves);

                echo $view->Render("note" . DS . "impression" . DS . "reportnotevierge", false);
                break;

            # Impression pour les statistiques par matieres accessible dans note/statistique/matiere
            case "0002":
                $notations = $this->Notation->getNotationsByMatieresByPeriode($this->request->idmatiere, $this->request->periode);
                $view->Assign("notations", $notations);


                # Construire un tableau ayant pour chaque notation, sa liste de note correspondante
                $array_notes = new ArrayObject();
                foreach ($notations as $n) {
                    $notes = $this->Note->findBy(["NOTATION" => $n['IDNOTATION']]);
                    $array_notes->offsetSet($n['IDNOTATION'], $notes);
                }
                $view->Assign("array_notes", $array_notes);

                $matiere = $this->Matiere->findSingleRowBy(["IDMATIERE" => $this->request->idmatiere]);
                $view->Assign("matiere", $matiere);
                echo $view->Render("note" . DS . "impression" . DS . "statistiqueparmatiere", false);
                break;


            # Impression pour les statistiques par classes Accessible par note/statistique
            case "0003":
                echo $view->Render("note" . DS . "impression" . DS . "statistiqueparclasse", false);
                break;

            # Impression de la fiche de note deja remplis Accessible par note/index
            case "0004":
                $notation = $this->Notation->findSingleRowBy(["IDNOTATION" => $this->request->idnotation]);
                $ens = $this->Enseignement->findSingleRowBy(["IDENSEIGNEMENT" => $notation['ENSEIGNEMENT']]);

                $notes = $this->Note->findBy(["NOTATION" => $this->request->idnotation]);
                $view->Assign("notation", $notation);
                $view->Assign("enseignement", $ens);
                $view->Assign("notes", $notes);
                echo $view->Render("note" . DS . "impression" . DS . "reportnote", false);
                break;
            case "0005":
                # Report de note sequentiell, accessible via note/saisie
                $eleves = $this->Inscription->getInscrits($this->request->idclasse, $this->session->anneeacademique);
                $view->Assign("eleves", $eleves);

                # Renvoyer un tableau contenant les id des eleve redoublant
                $array_of_redoublants = $this->Classe->getRedoublants($this->request->idclasse, $this->session->anneeacademique, true);
                $view->Assign("array_of_redoublants", $array_of_redoublants);
                $nbInscriptions = $this->Classe->getNBInscription($this->request->idclasse);
                $view->Assign("nbInscriptions", $nbInscriptions);
                $classe = $this->Classe->get($this->request->idclasse);
                $view->Assign("classe", $classe);

                echo $view->Render("note" . DS . "impression" . DS . "reportsequentiel", false);
                break;

            # Impression du proces verbal recapitulatif des resultats, Accessible via Notes et Bulletins/Recapitulatifs des resultats
            case "0006":

                $idperiode = $this->request->periode;
                $idclasse = $this->request->idclasse;
                $this->generateVarBulletin($view, $this->request->periode, $idclasse);
                $discipline = array();
                $view->Assign("discipline", $discipline);
                $array_of_redoublant = $this->Classe->getRedoublants($idclasse, $this->session->anneeacademique, true);
                $view->Assign("array_of_redoublants", $array_of_redoublant);

                $inscrits = $this->Inscription->getInscrits($idclasse);
                $view->Assign("effectif", count($inscrits));

                $this->Bulletin->dropTMPTable();

                # Discripline des eleves de cette classe 
                #$discipline = $this->Eleve->getDisciplines($idclasse, $sequence['DATEDEBUT'], $sequence['DATEFIN']);

                echo $view->Render("note" . DS . "impression" . DS . "procesverbalrecap", false);
                break;

            # Fiche synthese des recapitulatif disponible dans recapitulatif des resultats
            case "0007":

                $idclasse = $this->request->idclasse;
                $this->generateVarBulletin($view, $this->request->periode, $idclasse);
                $eleves = $this->Inscription->getInscrits($this->request->idclasse);
                $view->Assign("eleves", $eleves);
                echo $view->Render("note" . DS . "impression" . DS . "syntheserecapitulatif", false);
                break;

            # Impression de la courbe recapitulative des resultats accessible via recapitulatif des resultat dans Notes
            case "0008":
                $idperiode = $this->request->periode;
                $idclasse = $this->request->idclasse;
                $this->generateVarBulletin($view, $this->request->periode, $idclasse);
                echo $view->Render("note" . DS . "impression" . DS . "courberecapitulative", false);
                break;

            # TABLEAU D'HONNEUR accessible via recapitulatif des resultats
            case "0009":
                $idperiode = $this->request->periode;
                $idclasse = $this->request->idclasse;
                $this->generateVarBulletin($view, $idperiode, $idclasse);
                $array_of_redoublant = $this->Classe->getRedoublants($idclasse, $this->session->anneeacademique, true);
                $view->Assign("array_of_redoublants", $array_of_redoublant);
                echo $view->Render("note" . DS . "impression" . DS . "tableauhonneur", false);
                break;
        }
    }

    private function generateVarBulletin(&$view, $periode, $idclasse) {
        # S = Sequentielle, T = Trimestrielle, Autre pour annuelle
        $codeperiode = substr($periode, 0, 1);
        # Recuperer l'id de la periode
        $pos = strrpos($periode, "_");
        $idperiode = substr($periode, $pos + 1);
        if ($codeperiode === "S") {
            $this->Bulletin->createTMPNoteTable($idclasse, $idperiode);
            $rangs = $this->Bulletin->getElevesRang();
            $view->Assign("rangs", $rangs);
            $sequence = $this->Sequence->get($idperiode);
            $view->Assign("sequence", $sequence);
        } elseif ($codeperiode === "T") {
            $trimestre = $this->Trimestre->get($idperiode);
            $view->Assign("trimestre", $trimestre);
            $sequences = $this->Sequence->findBy(['TRIMESTRE' => $idperiode]);
            $array_of_sequences = [$sequences[0]['IDSEQUENCE'], $sequences[1]['IDSEQUENCE']];
            $this->Bulletin->createTrimestreTable($idclasse, $array_of_sequences);
            $rangs = $this->Bulletin->getElevesRang();
            $view->Assign("rangs", $rangs);
        } elseif ($codeperiode === "A") {
            # Obtenir les moyennes sequentielles
            $sequences = $this->Sequence->getIdSequences($_SESSION['anneeacademique']);
            $this->Bulletin->createMoySequentielTable();
            foreach ($sequences as $seq) {
                $this->getMoyRangSequentiel($idclasse, $seq);
            }
            $rangsequentiels = $this->Bulletin->getRangMoyenneSequences($sequences);
            $this->Bulletin->dropMoySequentielTable();
            $this->Bulletin->createAnnuelleTable($idclasse, $sequences);
            $rangs = $this->Bulletin->getElevesRangAnnuel();
            $moyclasse = $moymax = $moymin = 0;
            setrangannuel($rangs, $rangsequentiels, $moyclasse, $moymax, $moymin);
            $view->Assign("rangs", $rangs);
            $view->Assign("moyclasse", $moyclasse);
        }
        $notes = array();
        # Ajouter les notes par matiere, cette variable contient aussi les notes des eleves
        $enseignements = $this->Enseignement->getEnseignements($this->request->idclasse);
        $view->Assign("enseignements", $enseignements);
        foreach ($enseignements as $ens) {
            $notes = array_merge($notes, $this->Bulletin->getNotesByEnseignements($ens['IDENSEIGNEMENT']));
        }
        $view->Assign("notes", $notes);
        if ($codeperiode !== "A") {
            $rangs = $this->Bulletin->getElevesRang();
            $travail = $this->Bulletin->getGlobalMoyenne();
            $view->Assign("travail", $travail);
        }
        $classe = $this->Classe->get($idclasse);
        $view->Assign("classe", $classe);
        $this->Bulletin->dropTMPTable();
        $view->Assign("codeperiode", $codeperiode);
    }

    /**
     * Notifier les parents d'eleve pour cette notation obtenue
     * @param type $idnotation
     * @param string $type type de message dans BD, voir la table messages
     */
    public function notifyNotation($idnotation, $type = "0003") {
        # Format du SMS 
        /* Bjr Note de l'élève #eleve : #note/#notesur Mati&egrave; : #matiere Note maxi : #notemaxi
          Note mini : #notemini Note Moyenne : #notemoy #description du #datedevoir */
        $message = $this->Messagetype->getMessage($type)['MESSAGE'];
        # Obtenir les infos concernant cette notation
        $notation = $this->Notation->get($idnotation);

        # Pour chaque notes, rechercher les responsables de l'eleves et leurs envoyer
        $notes = $this->Note->findBy(["NOTATION" => $idnotation]);
        $retVal = false;

        foreach ($notes as $n) {
            $params = ["#eleve " => $n['NOM'],
                "#note " => $n['NOTE'],
                "#notesur " => $notation['NOTESUR'],
                "#matiere " => $notation['MATIERELIBELLE'],
                "#notemaxi " => $notation['NOTEMAX'],
                "#notemini " => $notation['NOTEMIN'],
                "#notemoy " => sprintf("%.2f", $notation['NOTEMOYENNE']),
                "#description " => $notation['DESCRIPTION'],
                "#datedevoir " => $notation['DATEDEVOIR']
            ];
            $m = $this->personnalize($params, $message);

            #Obtenir le parent de l'eleve
            $responsables = $this->Eleve->getResponsables($n['IDELEVE']);
            $retVal = $this->notifyResponsables($responsables, $m);
        }
        # Mettre a jour le nombre de notification envoye pour cette notation
        $this->Notation->update(["NOTIFICATION" => ($notation['NOTIFICATION'] + 1)], ["IDNOTATION" => $idnotation]);
        return $retVal;
    }

    private function notifyResponsables($responsables, $message) {
        $retVal = false;
        foreach ($responsables as $resp) {
            $tel = getRespNumPhone($resp);
            if (!empty($tel)) {
                $v = $this->send($tel, $message);
                if ($v) {
                    $retVal = $v;
                }
                sleep(3);
            }
        }
        return $retVal;
    }

    /**
     * Function egalement declareer dans bulletinController, chercher a le refactorier en mettant dans  la classe Controller
     * @param type $idclasse
     * @param type $idsequence
     */
    public function getMoyRangSequentiel($idclasse, $idsequence) {
        $this->Bulletin->createTMPNoteTable($idclasse, $idsequence);
        # Obtenir le rang des eleves
        $rangs = $this->Bulletin->getElevesRang();
        foreach ($rangs as $rang) {
            $params = ["eleve" => $rang['IDELEVE'],
                "moyenne" => sprintf("%.2f", $rang['MOYGENERALE']),
                "rang" => $rang['RANG'],
                "sequence" => $idsequence];
            $this->Bulletin->insertIntoMoySequentiel($params);
        }
    }

}
