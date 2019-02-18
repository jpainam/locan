<?php
$y = FIRST_TITLE;
# Utiliser dans appel/index et donc le code est 0004
# Utiliser pour afficher un resume d'absence par eleve dans une classe
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF

$titre = '<p style = "text-decoration:underline"><b>RESUME D\'ABSENCE DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, 60, $y, $titre);

$pdf->SetFont("helvetica", "", 12);
$titre = '<span style = "text-decoration:underline"><b>CLASSE</b></span><b> : ' . $classe['NIVEAUHTML'] . ' ' . $classe['LIBELLE'] . '</b>';
$pdf->WriteHTMLCell(0, 50, 10, $y + 15, $titre);
$pdf->SetFont("helveticaI", "B", 12);
$pdf->WriteHTMLCell(0, 5, 10, $y + 20, $libelle);

$pdf->SetFont("helvetica", "I", 12);
$d = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$semaine = '<span>P&eacute;riode du <b style="text-decoration:underline">' . $d->getDate() . " " . $d->getMois() . " " . $d->getYear()
        . '</b> au <b style="text-decoration:underline">'
        . $d2->getDate() . " " . $d2->getMois() . " " . $d2->getYear() . '</b></span>';
$pdf->WriteHTMLCell(0, 50, 70, $y + 7, $semaine);

$pdf->SetFont("Times", '', 12);

$corps = '<table cellpadding="2" border = "0.5" >
    <thead><tr style = "font-weight:bold;text-align:center"><th width="5%">N°</th>';
$corps .= '<th width="35%">Noms & Pr&eacute;noms</th><th width="15%">Abs. Non Just.</th><th width="13%">Abs. Just.</th>'
        . '<th width="10%">Retard</th><th width="12%">Exclusion</th><th width="10%">Total</th></tr></thead><tbody>';
$i = 1;
foreach ($eleves as $el) {
    $tab = getNbAbsencesResumees($el['IDELEVE'], $absences);
    $corps .= '<tr><td width="5%">' . $i . '</td><td style="text-align:left" width="35%">' . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
    $corps .= '<td style="text-align:center" width="15%">' . $tab[0] . " hrs</td>";
    $corps .= '<td style="text-align:center" width="13%">' . $tab[1] . " hrs</td>";
    $corps .= '<td style="text-align:center" width="10%">' . $tab[2] . " hrs</td>";
    $corps .= '<td style="text-align:center" width="12%">' . $tab[3] . " hrs</td>";
    $corps .= '<td style="text-align:center;font-weight:bold" width="10%">' . array_sum($tab) . "</td></tr>";
    $i++;
}
$corps .= "</tbody></table>";
$pdf->WriteHTMLCell(0, 5, 10, $y + 35, $corps);


$pdf->output();
