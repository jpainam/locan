<?php

$eff = 1; $prev = 0;    
setSpecialInterval($rangs, $eff, $prev, $debutinterval, $fininterval, $effectif); 

global $bas_bulletin;
if ($codeperiode === "S") {
    $bas_bulletin[1] = $sequence['VERROUILLER'];
} elseif ($codeperiode === "T") {
    $bas_bulletin[1] = "U";
} elseif ($codeperiode === "A") {
    $bas_bulletin[1] = "A";
}
$pdf->SetPrintFooter(true);
# Desactiver le texte de signature pour les bulletins
$pdf->bCertify = false;
$pdf->AddPage();

$pdf->leftUpCorner = 10;

# Largeur des colonnes
$col = getLargeurColonne($codeperiode);

#creer les trois groupes de matieres et envoyer cela a la vue
$tab = trierParGroupe($notes);
$groupe1 = $tab[0];
$groupe2 = $tab[1];
$groupe3 = $tab[2];
$array_of_redoublants = is_null($array_of_redoublants) ? array() : $array_of_redoublants;

# GRANDE BOUCLE POUR LES ELEVES DE LA CLASSE, EN COMMENCANT PAR LE 1er
# rang du precedent, utiliser pour determiner les execo


$style = array(
    'text' => true,
);

foreach ($rangs as $rang) {
    # Obtenir les autres infos de l'eleve

    $pdf->SetFont("Times", "B", 15);
    $y = PDF_Y;
    $pdf->RoundedRect(75, $y - 10, 75, 7, 2.0, '1111', 'DF', array("width" => 0.5, "color" => array(0, 0, 0)), array(255, 255, 255));
    if ($codeperiode === "A") {
        $titre = '<div>BULLETIN ANNUEL</div>';
    } else {
        $titre = '<div>BULLETIN DE NOTES</div>';
    }
    $pdf->WriteHTMLCell(0, 5, 85, $y - 10, $titre);
    $pdf->SetFont("Times", "B", 10);

    $annee = "Ann&eacute;e scolaire " . $_SESSION['anneeacademique'];
    $pdf->WriteHTMLCell(150, 5, 158, $y - 20, $annee);


# Le cadre pour la photo
    $photo = SITE_ROOT . "public/photos/eleves/" . $rang['PHOTOEL'];

    if (!empty($rang['PHOTOEL']) && file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $rang['PHOTOEL'])) {
        //ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . 
        $pdf->Image($photo, 15, $y, 20, 18, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
    } else {
        $pdf->WriteHTMLCell(20, 18, 15, $y, '<br/><br/>PHOTO', 1, 2, false, true, 'C');
    }
    $pdf->Rect(37, $y, 160, 13, 'DF');

    if (in_array($rang['IDELEVE'], $array_of_redoublants)) {
        $redoublant = "OUI";
    } else {
        $redoublant = "NON";
    }
    $pdf->SetFont("Times", "", 9);
    $d = new DateFR($rang['DATENAISSEL']);

    $matricule = 'Matricule&nbsp;: <b>' . $rang['MATRICULEEL'] . '</b>';
    $pdf->WriteHTMLCell(0, 5, 37, $y, $matricule);

    $nom = 'Nom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>' . $rang['NOMEL'] . " " . $rang['PRENOMEL'] . ' ' . $rang['AUTRENOMEL'] . '</b>';
    $pdf->WriteHTMLCell(0, 5, 37, $y + 4, $nom);
    $naiss = "N&eacute; ";
    if ($rang['SEXEEL'] === "F") {
        $naiss = "N&eacute;e ";
    }
    $naiss .= "le &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>"
            . $d->getDate() . " " . $d->getMois(3) . "-" . $d->getYear();
    if (!empty($rang['LIEUNAISSEL'])) {
        $naiss .= " &agrave; " . $rang['LIEUNAISSEL'];
    }
    $naiss .= '</b>';
    $pdf->WriteHTMLCell(0, 5, 37, $y + 8, $naiss);

    #Adresse
    #classe
    $classelib = 'Classe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; <b>' . $classe['NIVEAUHTML'] . '</b>';
    $pdf->WriteHTMLCell(50, 5, 165, $y, $classelib);
    $effectiflib = 'Effectif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; <b>' . $effectif . '</b>';
    $pdf->WriteHTMLCell(50, 5, 165, $y + 4, $effectiflib);
    $redo = "Redoublant &nbsp;:&nbsp; <b>" . $redoublant . '</b>';
    $pdf->WriteHTMLCell(50, 5, 165, $y + 8, $redo);

    $pdf->setFontSize(10);
    if ($codeperiode === "S") {
        $pdf->WriteHTMLCell(0, 5, 50, $y + 15, '<div style="text-transform:uppercase">' . $sequence['LIBELLEHTML'] . "</div>");
    } elseif ($codeperiode === "T") {
        $pdf->WriteHTMLCell(0, 5, 50, $y + 15, '<div style="text-transform:uppercase">' . $trimestre['LIBELLE'] . "</div>");
    }
    if($codeperiode === "S" || $codeperiode === "T"){
        $pdf->WriteHTMLCell(0, 5, 110, $y + 15, '<b>Prof. Princ : '. $classe['NOMPROFPRINCIPAL'].' '.$classe['PRENOMPROFPRINCIPAL']);
    }
    $pdf->setFontSize(8);

    # Table header
    if ($codeperiode === "T") {
        $seqs = getLibelleSequences($sequences);
        $attrs = ["codeperiode" => $codeperiode, "seq1" => $seqs[0], "seq2" => $seqs[1]];
    } elseif ($codeperiode === "S") {
        $attrs = ["codeperiode" => $codeperiode];
    } elseif ($codeperiode === "A") {
        $attrs = ["codeperiode" => $codeperiode];
    }
    $corps = getHeaderBulletin($enseignements, $col, $attrs);

    # FAIRE UNE BOUCLE SUR LES GROUPES DE MATIERES
    $st1 = $sc1 = $st2 = $sc2 = 0;
    if ($codeperiode === "A") {
        $corps .= getBodyAnnuelle($groupe1, $col, $rang, $st1, $sc1);
        $corps .= getBodyAnnuelle($groupe2, $col, $rang, $st2, $sc2);
        $corps .= getBodyAnnuelle($groupe3, $col, $rang);
    } else {
        $corps .= getBody($groupe1, $col, $rang, $codeperiode, $st1, $sc1);
        $corps .= getBody($groupe2, $col, $rang, $codeperiode, $st2, $sc2);
        //$corps .= printGroupe($st1 + $st2, $sc1 + $sc2, $col, "Groupe 1 + Groupe 2");
        $corps .= getBody($groupe3, $col, $rang, $codeperiode);
    }
    $corps .= "</tbody></table>";
    if ($codeperiode === "A") {
        $pdf->WriteHTMLCell(0, 5, 14, $y + 15, $corps);
    } else {
        $pdf->WriteHTMLCell(0, 5, 14, $y + 20, $corps);
    }

    # RESUME DU TRAVAIL ACCOMPLI
    $pdf->setFontSize(10);
    if ($codeperiode === "S") {
        $corps = printTravail($rang, $travail, $prev);
    } elseif ($codeperiode === "T") {
        $seq1 = getMoyRecapitulativeSequence($rang['IDELEVE'], $sequence1);
        $seq1["ORDRE"] = $sequences[0]['ORDRE'];
        $seq2 = getMoyRecapitulativeSequence($rang['IDELEVE'], $sequence2);
        $seq2["ORDRE"] = $sequences[1]['ORDRE'];
        $travail['MOYCLASSE'] = isset($moyclasse) ? $moyclasse : $travail['MOYCLASSE'];
        $travail['MOYMIN'] = isset($moymin) ? $moymin :  $travail['MOYMIN'];
        $travail['MOYMAX'] = isset($moymax) ? $moymax : $travail['MOYMAX'];
        $corps = printTravailTrimestre($rang, $travail, $prev, $seq1, $seq2);
    } elseif ($codeperiode === "A") {
        foreach ($recapitulatifs as $recap) {
            if ($recap['IDELEVE'] === $rang['IDELEVE']) {
                break;
            }
        }
        $corps = printMoyRangAnnuel($rang, $prev, $moyclasse, $moymax, $moymin);
        $pdf->WriteHTMLCell(0, 0, 95, $y + 167, $corps);
        $corps = printTravailAnnuel($rang, $recap, $prev);
    }
    $prev = $rang['RANG'];
    $pdf->WriteHTMLCell(0, 5, 14, $y + 167, $corps);

    # Discripline
    $x = 20;
    if ($codeperiode === "S") {
        foreach ($discipline as $disc) {
            if ($disc['IDELEVE'] == $rang['IDELEVE']) {
                break;
            }
        }
        $corps = printDiscipline($disc);
    } elseif ($codeperiode === "T") {
        $abs1 = getDisciplineRecapitulativeSequence($rang['IDELEVE'], $absence1);
        $abs2 = getDisciplineRecapitulativeSequence($rang['IDELEVE'], $absence2);
        $corps = printDisciplineTrimestre($abs1, $abs2, $sequences);
    } elseif ($codeperiode === "A") {
        $disc = array();
        foreach ($discipline as $d) {
            if ($d["IDELEVE"] === $rang['IDELEVE']) {
                $disc["ABS" . $d["ORDRESEQUENCE"]] = $d['ABSENCE'];
                $disc["JUST" . $d["ORDRESEQUENCE"]] = $d['JUSTIFIER'];
                $disc["CONS" . $d["ORDRESEQUENCE"]] = $d['CONSIGNE'];
            }
        }
        $corps = printDisciplineAnnuel($disc);
        $x = 14;
    }
    $pdf->WriteHTMLCell(0, 0, $x, $y + 182, $corps);

    # Specific a l'annuel
    if ($codeperiode === "A") {
        $corps = printObservationDecision();
        $pdf->WriteHTMLCell(150, 0, 139, $y + 182, $corps);
    }
    $pdf->setFont("helvetica", '', 8);

# Desinner la coube d'evolution
    $moyennes = getMoyennesRecapitulatives($recapitulatifs, $rang['IDELEVE'], $codeperiode);
    if ($codeperiode !== "A") {
        $moyennes[] = $rang['MOYGENERALE'];
    }

    genererCourbe($moyennes, $rang, $codeperiode);
    $courbe = SITE_ROOT . "public/tmp/" . $rang['IDELEVE'] . ".png";
    $pdf->Image($courbe, 18, $y + 200, 55, 40, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $filename = ROOT . DS . "public" . DS . "tmp" . DS . $rang['IDELEVE'] . ".png";
    if (file_exists($filename)) {
        try {
            unlink($filename);
        } catch (Exception $e) {
            
        }
    }

    $pdf->StartTransform();
    $pdf->setFontSize(5);
# Ajouter la signature et l'heure d'impression
    $pdf->Rotate(90, 5, $y + 161);

    $pdf->WriteHTMLCell(0, 5, 20, $y + 166, "G&eacute;n&eacute;r&eacute; par BAACK @ IPW version 1.0<br/>" .
            date("d/m/Y ", time()) . "&agrave; " . date("H:i:s", time()));
    $pdf->StopTransform();
    $pdf->StartTransform();
    $pdf->Rotate(90, 35, $y + 185);
    $pdf->Write1DBarcode($rang['MATRICULEEL'], 'C128A', 12, $y + 155, '', 7, 0.4);
    $pdf->StopTransform();

    $pdf->StartTransform();
    $pdf->Rotate(90, 15, $y + 171);
# Numero de la page
    $pdf->WriteHTMLCell(50, 5, 20, $y + 166, '<b>' . $rang['RANG'] . '/' . $effectif . '</b>');
    $pdf->StopTransform();

    $pdf->setFont("helvetica", '', 8);
    # Visa des parents
    $pdf->WriteHTMLCell(0, 5, 80, $y + 205, 'Visa des Parents');
    # Titulaire
    $pdf->WriteHTMLCell(0, 5, 125, $y + 205, 'Le titulaire');
    # Le Directeur des etudes
    if ($codeperiode === "S") {
        $pdf->WriteHTMLCell(100, 5, 165, $y + 205, 'Le Directeur des &eacute;tudes');
    } else {
        $pdf->WriteHTMLCell(100, 5, 165, $y + 205, 'Le chef d\'&eacute;tablissement');
    }
    $bas_bulletin[0] = $rang['NOMEL'] . " " . $rang['PRENOMEL'];

    $eff++;
    if ($eff <= $fininterval) {
        $pdf->AddPage();
    }
}

$pdf->Output();
