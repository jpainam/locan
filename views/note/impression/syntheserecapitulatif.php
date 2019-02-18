<?php
$y = PDF_Y;
$pdf->setPageOrientation('L');
$pdf->isLandscape = true;
$middle = PDF_MIDDLE;
$x = PDF_X;
$pdf->bCertify = false;

$pdf->AddPage();
$pdf->SetPrintHeader(false);

$pdf->WriteHTMLCell(0, 5, $middle - 10, $y - 5, '<b>SYNTHESE - RECAPITULATIVE DES RESULTATS</b>');
$pdf->setFont("Times", '', 8);
$col = [3, 30, 15];

$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[1] . '%">PERIODE</td>';
if ($codeperiode === "S") {
    $corps .= '<td border="1" align="center" width="' . $col[2] . '%">SEQUENCE N° ' . $sequence['SEQUENCEORDRE'] . '</td></tr>';
} else {
    $corps .= '<td border="1" align="center" width="' . $col[2] . '%">TRIMESTRE N° ' . $trimestre['ORDRE'] . '</td></tr>';
}
$corps .= '<tr><td border="1" width="' . $col[1] . '%">CLASSE</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $classe['NIVEAUHTML'] . '</td></tr>'
        . '</table>';
$pdf->WriteHTMLCell(260, 5, $x + 10, $y + 7, $corps);
$pdf->WriteHTMLCell(100, 5, $x + 135, $y + 7, 'ANNEE SCOLAIRE ' . $_SESSION['anneeacademique'], 1);
$effectif = count($eleves);
$present = count($rangs);


$tab = getInformationCellule($rangs);
$dispo = getEleveInformation($eleves);

$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[1] . '%">EFFECTIF</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $effectif . '</td></tr>'
# PRESENTS
        . '<tr><td border="1" width="' . $col[1] . '%">PRESENTS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $present . '</td></tr>'
# ABSENT
        . '<tr><td border="1" width="' . $col[1] . '%">ABSENT</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . ($effectif - $present) . '</td></tr>'
# Moyenne de classe
        . '<tr><td border="1" width="' . $col[1] . '%">MOYENNE DE LA CLASSE</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf("%.2f", $travail['MOYCLASSE']) . '</td></tr>'
# Nombre de moyenne
        . '<tr><td border="1" width="' . $col[1] . '%">NOMBRE DE MOYENNE</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $tab[0] . '</td></tr>'
        . '<tr><td border="1" width="' . $col[1] . '%">POURCENTAGE DE REUSSITE</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf('%.2f', $tab[0] / $present * 100) . '%</td></tr>'
        . '</table>';

$pdf->WriteHTMLCell(260, 5, $x + 10, $y + 20, $corps);

$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[1] . '%">EFFECTIF GARCONS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $dispo[0] . '</td></tr>'
# GARCON AYANT COMPOSER
        . '<tr><td border="1" width="' . $col[1] . '%">GARCONS AYANT COMPOSES</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $tab[1] . '</td></tr>'
# NB MOYENNE GARCON
        . '<tr><td border="1" width="' . $col[1] . '%">NOMBRE DE MOYENNE GARCONS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $tab[3] . '</td></tr>'
# Pourcentage de garcon reussite
        . '<tr><td border="1" width="' . $col[1] . '%">POURCENTAGE DE REUSSITE GARCONS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf("%.2f", $tab[3] / $tab[1] * 100) . '%</td></tr>'
        . '</table>';

$pdf->WriteHTMLCell(260, 5, $x + 10, $y + 50, $corps);


# FILLES
$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[1] . '%">EFFECTIF FILLES</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $dispo[1] . '</td></tr>'
# GARCON AYANT COMPOSER
        . '<tr><td border="1" width="' . $col[1] . '%">FILLES AYANT COMPOSEES</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $tab[2] . '</td></tr>'
# NB MOYENNE GARCON
        . '<tr><td border="1" width="' . $col[1] . '%">NOMBRE DE MOYENNE FILLES</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . $tab[4] . '</td></tr>'
# Pourcentage de garcon reussite
        . '<tr><td border="1" width="' . $col[1] . '%">POURCENTAGE DE REUSSITE FILLES</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf("%.2f", $tab[4] / $tab[2] * 100) . '%</td></tr>'
        . '</table>';
$pdf->WriteHTMLCell(260, 5, $x + 143, $y + 50, $corps);

$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[0] . '%">N°</td>'
        . '<td border="1" width="' . $col[1] . '%">DIX PREMIERS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">AVERAGE</td></tr>';
$i = 1;
foreach ($rangs as $rang) {
    if ($i > 10) {
        break;
    }
    $corps .= '<tr><td border="1" width="' . $col[0] . '%">' . $i . '</td>'
            . '<td border="1" width="' . $col[1] . '%">' . $rang['NOMEL'] . ' ' . $rang['PRENOMEL'] . '</td>'
            . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf("%.2f", $rang['MOYGENERALE']) . '</td></tr>';
    $i++;
}
$corps .= '</table>';

$pdf->WriteHTMLCell(260, 5, $x + 10, $y + 75, $corps);

$corps = '<table cellpadding="1"><tr><td border="1" width="' . $col[0] . '%">N°</td>'
        . '<td border="1" width="' . $col[1] . '%">DIX DERNIERS</td>'
        . '<td border="1" align="center" width="' . $col[2] . '%">AVERAGE</td></tr>';

$j = 1;
for ($i = ($present - 1); $i >= 0, $j <= 10; $i--) {
    $rang = $rangs[$i];
    $corps .= '<tr><td border="1" width="' . $col[0] . '%">' . $j . '</td>'
            . '<td border="1" width="' . $col[1] . '%">' . $rang['NOMEL'] . ' ' . $rang['PRENOMEL'] . '</td>'
            . '<td border="1" align="center" width="' . $col[2] . '%">' . sprintf("%.2f", $rang['MOYGENERALE']) . '</td></tr>';
    $j++;
}
$corps .= '</table>';
$pdf->WriteHTMLCell(260, 5, $x + 135, $y + 75, $corps);
$pdf->Output();

function getInformationCellule($notes) {
    $tab = [0, 0, 0, 0, 0, 0, 0, 0];
# 0 NB Moyenne
# 1 NB Garcon compose
# 2 NB FILLE compose
# 3 NB mOY Garcon
# 4 NB MOY FILLE
    foreach ($notes as $n) {
        if ($n['MOYGENERALE'] >= 10) {
            $tab[0] += 1;
            if ($n['SEXEEL'] === "M") {
                $tab[3] += 1;
            } elseif ($n['SEXEEL'] === "F") {
                $tab[4] += 1;
            }
        }
        if ($n['SEXEEL'] === "M") {
            $tab[1] += 1;
        }
    }
# 2 Fille compose
    $tab[2] = count($notes) - $tab[1];
    return $tab;
}

function getEleveInformation($eleves) {
#0 Nbre de garcon
#1 Nombre de fille
    $tab = [0, 0, 0, 0];
    foreach ($eleves as $el) {
        if ($el['SEXE'] === "M") {
            $tab[0] += 1;
        }
    }
    $tab[1] = count($eleves) - $tab[0];
    return $tab;
}
