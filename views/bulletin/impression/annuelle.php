<?php

global $bas_bulletin;
$bas_bulletin[0] = "";
$bas_bulletin[1] = "";

$pdf->SetPrintFooter(true);
# Desactiver le texte de signature pour les bulletins
$pdf->bCertify = false;
$pdf->AddPage();
$y = PDF_Y;

$pdf->leftUpCorner = 10;

$array_of_redoublants = is_null($array_of_redoublants) ? array() : $array_of_redoublants;
$eff = 1;
#creer les trois groupes de matieres et envoyer cela a la vue
$tab = trierParGroupe($notes);
$groupe1 = $tab[0];
$groupe2 = $tab[1];
$groupe3 = $tab[2];

$style = array(
    'text' => true,
);
# rang du precedent, utiliser pour determiner les execo
$prev = 0;

foreach ($rangs as $rang) {

    $pdf->SetFont("Times", "B", 15);
    $y = PDF_Y;
    $pdf->RoundedRect(75, $y - 10, 75, 7, 2.0, '1111', 'DF', array("width" => 0.5, "color" => array(0, 0, 0)), array(255, 255, 255));

    $titre = '<div>BULLETIN ANNUEL</div>';
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

    $pdf->setFontSize(8);

    $col = [5, 5, 5, 5, 5, 5, 5, 6, 6, 12, 37, 5, 10, 7];

    $line_height = "10px";
    /* if ($nbMatieres > 14) {
      $line_height = "8px";
      } */

    $corps = '<table cellpadding="0.5" style="line-height: ' . $line_height . '">
    <thead>
        <tr style="text-align:center;font-weight:bold;font-size:7px;line-height: 15px;">
        <th width="' . $col[10] . '%"></th>
           <th colspan="2" width="' . $col[12] . '%" border="1">1<sup>er</sup>Trimestre</th>
        <th border="1" colspan="2"  width="' . $col[12] . '%">2<sup>nd</sup>Trimestre</th>
            <th border="1" colspan="2" width="' . $col[12] . '%">3<sup>e</sup>Trimestre</th><th colspan="5"></th></tr>
        <tr style="text-align:center;font-weight:bold; line-height: 15px;font-size:8px;background-color:#000;color:#FFF;">
            <th border="1" width="' . $col[10] . '%">Mati&egrave;res</th>
            <th width="' . $col[1] . '%">S1</th>
            <th width="' . $col[2] . '%">S2</th>
            <th width="' . $col[3] . '%">S3</th>
            <th width="' . $col[4] . '%">S4</th><th  width="' . $col[5] . '%">S5</th>
            <th width="' . $col[6] . '%">S6</th>
            <th width="' . $col[7] . '%" border="1">Moy</th>
            <th  width="' . $col[11] . '%" border="1">Coef</th>
            <th width="' . $col[13] . '%" border="1">Total</th>
            <th width="' . $col[8] . '%" border="1">Rang</th>
            <th width="' . $col[9] . '%" border="1">Appr&eacute;ciation</th></tr>
        </thead>
        <tbody>';
    $st1 = $sc1 = $st2 = $sc2 = 0;
    $corps .= getBodyAnnuelle($groupe1, $col, $rang, $st1, $sc1);
    $corps .= getBodyAnnuelle($groupe2, $col, $rang, $st2, $sc2);
    //$corps .= printGroupe($st1 + $st2, $sc1 + $sc2, $col, "Groupe 1 + Groupe 2");
    $corps .= getBodyAnnuelle($groupe3, $col, $rang);

    $corps .= '</tbody></table>';

    $pdf->WriteHTMLCell(0, 5, 14, $y + 15, $corps);
    # TRAVAIL ET DISCIPLINE
    foreach ($recapitulatifs as $recap) {
        if ($recap['IDELEVE'] === $rang['IDELEVE']) {
            break;
        }
    }
    $corps = printTravailAnnuel($rang, $recap, $prev);
    $pdf->WriteHTMLCell(0, 5, 14, $y + 168, $corps);
    
    # Print Discipline
    # 
    # Generer Courbe
    $moyennes = getMoyennesRecapitulatives($recapitulatifs, $rang['IDELEVE'], $codeperiode);
    //$moyennes[] = $rang['MOYGENERALE'];

    genererCourbe($moyennes, $rang);
    $courbe = SITE_ROOT . "public/tmp/" . $rang['IDELEVE'] . ".png";
    $pdf->Image($courbe, 18, $y + 200, 55, 40, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $filename = SITE_ROOT . "public" . DS . "tmp" . DS . $rang['IDELEVE'] . ".png";
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
    $pdf->Rotate(90, 45, $y + 190);
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
    $pdf->WriteHTMLCell(0, 5, 125, $y + 205, 'Titulaire');

    
    $pdf->WriteHTMLCell(100, 5, 165, $y + 205, 'Chef d\'&eacute;tablissement');

    $bas_bulletin[0] = $rang['NOMEL'] . " " . $rang['PRENOMEL'];

    $prev = $rang['RANG'];
    $eff++;
    if ($eff <= $effectif) {
        $pdf->AddPage();
    }
}
$pdf->Output();
