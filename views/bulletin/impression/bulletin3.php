<?php

var_dump($notes);
echo "<table style='border-collapse:collapse'>";
foreach ($notes as $note) {
    echo "<tr>";
    foreach ($note as $n) {
        echo "<td style='border:1px solid #000'>" . $n . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

die();
# Largeur des colonnes
$col1 = 25;
$col2 = 7;
$col3 = 7;
$col4 = 7;
$col5 = 7;
$col6 = 7;
$col7 = 7;
$col8 = 7;
$col9 = 8;
$col10 = 10;

$pdf->SetFont("Times", "B", 10);
$y = FIRST_TITLE;
$titre = "BULLETIN";
$pdf->WriteHTMLCell(0, 5, 95, $y - 5, $titre);

$annee = "Ann&eacute;e scolaire " . $_SESSION['anneeacademique'];
$pdf->WriteHTMLCell(0, 5, 85, $y, $annee);

$pdf->WriteHTMLCell(0, 5, 95, $y + 5, $libelle);

# Le cadre pour la photo
if (!empty($eleve['PHOTO'])) {
    $photo = SITE_ROOT . "public/photos/eleves/" . $eleve['PHOTO'];
    $pdf->Image($photo, 21, $y + 7, 25, '', '', '', 'T', false, 300, '', false, false, 1, false, false, false);
} else {
    $pdf->WriteHTMLCell(25, 25, 21, $y + 7, '<br/><br/>PHOTO', 1, 2, false, true, 'C');
}

if (in_array($eleve['IDELEVE'], $array_of_redoublants)) {
    $redoublant = "OUI";
} else {
    $redoublant = "NON";
}
$pdf->SetFont("Times", "", 10);
$d = new DateFR($eleve['DATENAISS']);
$naiss = "N&eacute;e le " . $d->getDate() . " " . $d->getMois(3) . "-" . $d->getYear() . " &agrave; "
        . $eleve['LIEUNAISS'];
$pdf->WriteHTMLCell(0, 5, 47, $y + 20, $eleve['MATRICULE'] . " - " . $eleve['NOM'] . " " . $eleve['PRENOM']);
$pdf->WriteHTMLCell(0, 5, 47, $y + 25, $naiss);

$redo = "Redoublant : " . $redoublant;
$pdf->WriteHTMLCell(0, 5, 155, $y + 20, $redo);
$pdf->WriteHTMLCell(0, 5, 155, $y + 25, $classe['NIVEAUHTML'] . "   Effectif : " . $effectif);

$pdf->setFontSize(8);
# Table header
$corps = '<table border="0.5" cellpadding="0.5" style="line-height: 11px"><thead>'
        . '<tr style="text-align:center;font-weight:bold; line-height: 14px;background-color:#CCC">'
        . '<th border="0.5"  width="' . $col1 . '%" style="text-align:left">Mati&egrave;res</th><th border="0.5" width="' . $col2 . '%">DP</th>'
        . '<th border="0.5"  width="' . $col3 . '%">DH</th><th border="0.5" width="' . $col4 . '%">Moy.</th>'
        . '<th border="0.5"  width="' . $col5 . '%">Coeff.</th><th border="0.5"  width="' . $col6 . '%">Total</th>'
        . '<th border="0.5" width="' . $col7 . '%">Rang</th>'
        . '<th border="0.5"  width="' . $col8 . '%">Moy.Cl</th>'
        . '<th border="0.5"  width="' . $col9 . '%">Min/Max</th>'
        . '<th border="0.5"  width="' . $col10 . '%">Appr&eacute;ciation</th></tr></thead><tbody>';

foreach ($groupe as $gp) {
    if(empty($gp)){
        continue;
    }
    # Impression des lignes du bulletin par groupe
    $sumdp = 0;
    $sumdh = 0;
    $sumcoeff = 0;
    $sumtotal = 0;
    foreach ($gp as $g) {
        $corps .= '<tr style="text-align:center">'
                . '<td border="0.5" style="text-align:left" width="' . $col1 . '%">' . strtoupper($g['BULLETIN']) .
                '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . $g['CIVILITE'] . ' ' . $g['NOM'] . ' ' . $g['PRENOM'] . '</td>';

        # Obtenir la note pour cet enseignement
        $note = $notes[$g['IDENSEIGNEMENT']];

        # S'il ne dispose d'aucune note
        if (empty($note)) {
            $notedp = 0.00;
            $notedh = 0.00;
        }
        # Premier note est le DP car nous l'avons ordonner par ordre croisant dans la requete
        if (isset($note[0])) {
            $notedp = $note[0]['NOTE'];
        } else {
            $notedp = 0.00;
        }
        $corps .= '<td border="0.5" width="' . $col2 . '%">' . sprintf("%.2f", $notedp) . '</td>';

        # Note DH
        if (isset($note[1])) {
            $notedh = $note[1]['NOTE'];
        } else {
            $notedh = 0.00;
        }
        $corps .= '<td border="0.5" width="' . $col3 . '%">' . sprintf("%.2f", $notedh) . '</td>';

        # Moyenne de DU et DP
        $moy = ($notedp + $notedh) / 2;
        $corps .= '<td border="0.5" width="' . $col4 . '%">' . sprintf("%.2f", $moy) . '</td>';

        #Coefficient
        $corps .= '<td border="0.5" width="' . $col5 . '%">' . $g['COEFF'] . '</td>';

        #Total
        $total = $moy * $g['COEFF'];
        $corps .= '<td border="0.5" width="' . $col6 . '%">' . sprintf("%.2f", $total) . '</td>';

        #Rang
        $corps .= '<td border="0.5" width="' . $col7 . '%"></td>';

        #Moyenne de classe
        $corps .= '<td border="0.5" width="' . $col8 . '%"></td>';

        #Min / Max
        $corps .= '<td border="0.5" width="' . $col9 . '%"></td>';

        #Appreciation
        $corps .= '<td border="0.5" width="' . $col10 . '%">' . getAppreciations($moy) . '</td>';

        # Sommes
        $sumdh += $notedh;
        $sumdp += $notedp;
        $sumcoeff += $g['COEFF'];
        $sumtotal += $total;

        $corps .= '</tr>';
    }

    # Ecrire le GROUPE 1
    $corps .= '<tr style="background-color:#F7F7F7;line-height:14px;text-align:center;">'
            . '<td border="0.5" witdh="' . $col1 . '%" style="text-align:left">' . $gp[0]['DESCRIPTION'] . '</td>'
            . '<td border="0.5" width="' . $col2 . '%">' . $sumdp . '</td>'
            . '<td border="0.5" width="' . $col3 . '%">' . $sumdh . '</td>';
    # Moyenne totale du groupe 
    $moy = ($sumdh + $sumdp) / $sumcoeff;
    $corps .= '<td border="0.5" width="' . $col4 . '%">' . sprintf("%.2f", $moy) . '</td>'
            . '<td border="0.5" width="' . $col5 . '%">' . $sumcoeff . '</td>'
            . '<td border="0.5" width="'.$col6.'%">'.$sumtotal.'</td>'
            . '<td style="text-align:left" border="0.5" colspan="4" width="' . ($col7 + $col8 + $col9 + $col10) . '%">'
            . 'Moyenne : </td></tr>';
}
$corps .= "</tbody></table>";
$pdf->WriteHTMLCell(0, 5, 20, $y + 35, $corps);
$pdf->Output();
