<?php

$y = PDF_Y;
$x = PDF_X;
$middle = PDF_MIDDLE;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
//Titre du PDF
$pdf->SetFont("Times", 'B', 10);


$titre = '<p style = "text-decoration:underline"><b>LISTE D\'APPEL DE L\'ANNEE SCOLAIRE ' . $anneescolaire . '</b></p>';
$pdf->WriteHTMLCell(0, 50, $middle - 40, $y - 10, $titre);

$titre = '<span style = "text-decoration:underline"><b>CLASSE</b></span><b> : ' . $classe['NIVEAUHTML'] . '</b>';
$pdf->WriteHTMLCell(0, 50, $middle - 10, $y, $titre);

$d1 = new DateFR($datedebut);
$d2 = new DateFR($datefin);
$semaine = '<span>Semaine du <b style="text-decoration:underline">' .
        $d1->getDate() . " " . $d1->getMois(3) . " " . $d1->getYear()
        . '</b> au <b style="text-decoration:underline">'
        . $d2->getDate() . " " . $d2->getMois(3) . " " . $d2->getYear() . '</b></span>';
$pdf->WriteHTMLCell(100, 50, 135, 10 + $y, $semaine);

$tab = getEffectifs($eleves);
$pdf->WriteHTMLCell(0, 5, $x, $y + 10, '<span style="text-decoration:underline">Filles</span> : <b>' . $tab[0] . '</b>');
$pdf->WriteHTMLCell(0, 5, $x + 40, $y + 10, '<span style="text-decoration:underline">Gar&ccedil;ons</span>  : <b>' . $tab[1] . '</b>');
$pdf->WriteHTMLCell(0, 5, $x, $y + 15, '<span style="text-decoration:underline">Effectif Total</span> : <b>' . $tab[2] . '</b>');
$pdf->SetFont("Times", '', 10);

# Nombre de colonnes, pour les 1eres et Tle, 9 colonnes
$l = getNbHoraire($classe['GROUPE']);
$pdf->SetFont("Times", '', 8);
$corps = '<table cellpadding="2">
    <thead><tr border ="0.5" style = "font-weight:bold"><th border ="0.5" width ="3%">N°</th>
            <th border ="0.5" align="center" width ="23%">Noms  Pr&eacute;noms</th>
            <th border ="0.5" align="center" width ="5%">Sexe</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Lundi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Mardi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Mercredi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Jeudi</th>
            <th border ="0.5" align="center" width ="14%" style="border-right:2px solid #000000" colspan="' . $l . '">Vendredi</th>
            <th border ="0.5" align="center" width ="5%">Total</th></tr></thead><tbody><tr>';
$corps .= '<td border ="0.5" align="center" colspan="3" width ="31%"><b>HEURES</b></td>';
for ($i = 1; $i <= $l * 5; $i++) {
    if ($i % $l == 0) {
        $corps .= '<td border ="0.5"  style="border-right:2px solid #000000" width ="' . (14 / $l) . '%"></td>';
    } else {
        $corps .= '<td border ="0.5"  width ="' . (14 / $l) . '%"></td>';
    }
}
$corps .= '<td border ="0.5"  width ="5%"></td></tr>';
$i = 1;

foreach ($eleves as $el) {
    $corps .= '<tr>';
    if ($i < 10) {
        $corps .= '<td border ="0.5"  width ="3%">0' . $i . '</td>';
    } else {
        $corps .= '<td border ="0.5"  width ="3%">' . $i . '</td>';
    }
    $appelation = $el['NOM'] . ' ' . $el['PRENOM'];
    if (strlen($appelation) > 15) {
        $corps .= '<td border ="0.5"  width ="23%" style="font-size:6px">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>';
    } else {
        $corps .= '<td border ="0.5"  width ="23%">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>';
    }

    $corps .= '<td border ="0.5"  width ="5%" align="center" >' . $el['SEXE'] . '</td>';
    for ($j = 1; $j <= $l * 5; $j++) {
        if ($j % $l == 0) {
            $corps .= '<td border ="0.5"  style="border-right:2px solid #000000" width ="' . (14 / $l) . '%"></td>';
        } else {
            $corps .= '<td border ="0.5"  width ="' . (14 / $l) . '%"></td>';
        }
    }
    $corps .= '<td border ="0.5" width ="5%" ></td></tr>';
    $i++;
}
$corps .= '</tbody></table>';


$pdf->WriteHTMLCell(0, 5, 5, 25 + $y, $corps);
$pdf->output();

function getEffectifs($eleves) {
    $tab = [0, 0, 0];
    $tab[2] = count($eleves);
    foreach ($eleves as $el) {
        if ($el['SEXE'] == "M") {
            $tab[1] ++;
        } elseif ($el['SEXE'] == "F") {
            $tab[0] ++;
        }
    }
    return $tab;
}
