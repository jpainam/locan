<?php

#Fiche de report de note
# accessible grace a note/index
# code d'impression 0004

$y = FIRST_TITLE;

$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF

$titre = '<p style = "text-decoration:underline">FICHE DE REPORT DE NOTES ' . $anneescolaire . '</p>';
$pdf->WriteHTMLCell(0, 50, 60, $y, $titre);


$pdf->SetFont("Times", "", 13);
$titre = '<i>' . $enseignement['NIVEAUHTML'] . ' ' . $enseignement['CLASSELIBELLE'] . "</i>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $titre);

$pdf->WriteHTMLCell(0, 5, 90, $y + 15, '<p>Note sur : <i>' . $notation['NOTESUR'] . '</i></p>');

$enseignant = '<p><i>' . $enseignement['NOM'] . "</i></p>";
$pdf->WriteHTMLCell(150, 5, 140, $y + 15, $enseignant);

$d = new DateFR($notation['DATEDEVOIR']);
$pdf->WriteHTMLCell(0, 5, 10, $y + 20, '<i>' . $d->getJour(3) . ' ' . $d->getDate() . ' ' . $d->getMois(3) . ' ' . $d->getYear() . '</i>');

$matiere = '<p><i>' . $enseignement['BULLETIN'] . '</i></p>';
$pdf->WriteHTMLCell(150, 5, 140, $y + 20, $matiere);

$pdf->WriteHTMLCell(0, 5, 90, $y + 20, '<p>Note maxi : <i>' . $notation['NOTEMAX'] . '</i></p>');

$libelle = '<i>' . $notation['DESCRIPTION'] . '</i>';
$pdf->WriteHTMLCell(0, 5, 10, $y + 25, $libelle);
$pdf->WriteHTMLCell(0, 5, 10, $y + 30, '<i>Effectif : ' . count($notes) . '</i>');

$pdf->WriteHTMLCell(0, 5, 90, $y + 25, '<p>Note mini : <i>' . $notation['NOTEMIN'] . '</i></p>');

$pdf->WriteHTMLCell(0, 5, 140, $y + 25, '<p>Coefficient : <i>' . $enseignement['COEFF'] . '</i></p>');

$pdf->WriteHTMLCell(0, 5, 90, $y + 30, '<p>Note moy. : <i>' . sprintf("%.2f", $notation['NOTEMOYENNE']) . '</i></p>');

$pdf->WriteHTMLCell(0, 5, 140, $y + 30, '<p>P&eacute;riode : ' . $notation['SEQUENCELIBELLE'] . '</p>');

$corps = '<table border="0.5" cellpadding="5"><tr style="text-align:center"><td rowspan="2">Effectif &eacute;valu&eacute;</td>'
        . '<td rowspan="2">Moyenne g&eacute;n&eacute;rale de la classe</td>'
        . '<td rowspan="2">Nombre de Moy >= 10</td>'
        . '<td colspan="2">Taux de r&eacute;ussite</td><td rowspan="2">Taux de r&eacute;ussite g&eacute;n&eacute;ral</td>'
        . '<td rowspan="2">Observation</td></tr>'
        . '<tr><td>Gar&ccedil;ons</td><td>Filles</td></tr>';
$nbre = effectifEvalues($notes);
# taux[0] = taux des garcons
# taux[1] = taux des filles
# taux[2] = taux generale de reussite

$taux = tauxReussites($notes);
$corps .= '<tr style="text-align:center"><td>' . $nbre . '</td><td>' . sprintf("%.2f", $notation['NOTEMOYENNE']) . '</td>'
        . '<td>' . count(moyenneSup10($notes)) . '</td>'
        . '<td>' . sprintf("%.2f", $taux[0]) . '%</td><td>' . sprintf("%.2f", $taux[1]) . '%</td><td>' . sprintf("%.2f", $taux[2]) . '%</td>'
        . '<td>' . getAppreciations($notation['NOTEMOYENNE']) . '</td></tr>';

$corps .= '</table>';
$pdf->WriteHTMLCell(0, 5, 10, $y + 40, $corps);


$corps = '<table cellpadding = "2"><thead ><tr border="0.5" style="font-weight:bold"><th width="5%" border="0.5">N°</th>'
        . '<th border="0.5"width="50%">Noms et Pr&eacute;noms</th>';
$corps .= '<th width="10%" border="0.5">Note</th><th width="15%" border="0.5">Absent</th>'
        . '<th width="20%" border="0.5">Observations</th></tr></thead><tbody>';
$i = 1;
foreach ($notes as $n) {
    $absent = "";
    $ap = getAppreciations($n['NOTE']);
    $corps .= '<tr><td width="5%" border="0.5">' . $i . '</td>'
            . '<td width="50%" border="0.5">' . $n['NOM'] . ' ' . $n['PRENOM'] . '</td>';
    if ($n['ABSENT'] == 1) {
        $n['NOTE'] = "";
        $absent = 'ABSENT';
        $ap = "";
    }
    $corps .= '<td width="10%" border="0.5">' . $n['NOTE'] . '</td>'
            . '<td width="15%" border="0.5">'.$absent.'</td>'
            . '<td width="20%" border="0.5">'.$ap.'</td></tr>';
    $i++;
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, 10, $y + 80, $corps);


$pdf->Output();
