<?php

$y = PDF_Y;
$pdf->setPageOrientation('L');
$pdf->isLandscape = true;
$middle = PDF_MIDDLE;
$x = PDF_X;

$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetPrintHeader(false);

$pdf->WriteHTMLCell(0, 5, $middle - 10, $y - 5, '<b>COURBE - RECAPITULATIVE DES RESULTATS</b>');
$pdf->setFont("Times", '', 8);
$col = [3, 30, 15];

$datax = array();
$corps = '<table cellpadding="2"><tr><td></td>';
foreach ($enseignements as $ens) {
    $lbl = substr(str_replace(".", "", $ens['BULLETIN']), 0, 4);
    $datax[] = $lbl;
    $corps .= '<td border="1" align="center"><b style="text-transform:uppercase">'
            . $lbl . '</b></td>';
}
$corps .= '</tr><tr><td border="1">Moy.Classe</td>';

$datay1 = array();
foreach ($enseignements as $ens) {
    $valeur = getMoyClassePourCourbe($ens['IDENSEIGNEMENT'], $notes);
    $datay1[] = $valeur;
    $corps .= '<td border="1" align="center">' . $valeur . '</td>';
}

$corps .= '</tr><tr><td border="1">%REUSSITE</td>';

$datay2 = array();
foreach ($enseignements as $ens) {
    $valeur = getPourcentageReussitePourCourbe($ens['IDENSEIGNEMENT'], $notes);
    $datay2[] = $valeur;
    $corps .= '<td border="1" align="center">' . getPourcentageReussitePourCourbe($ens['IDENSEIGNEMENT'], $notes) . '%</td>';
}
$corps .= '</tr></table>';


tracerCourbeMoyennes($datax, $datay1, $datay2);
$courbe = SITE_ROOT . "public/tmp/courbe.png";
$pdf->Image($courbe, 25, $y + 5, 250, 120, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$filename = ROOT . DS . "public" . DS . "tmp" . DS . "courbe.png";

if (file_exists($filename)) {
    try {
        unlink($filename);
    } catch (Exception $e) {
        
    }
}

$pdf->setPageMark();
$pdf->WriteHTMLCell(0, 5, $x, $y + 105, $corps);

$pdf->WriteHTMLCell(100, 5, $middle + 100, $y, '<b>CLASSE ' . $classe['NIVEAUHTML'] . '</b>');
if ($codeperiode === "S") {
    $pdf->WriteHTMLCell(100, 5, $middle + 100, $y + 5, '<b>SEQUENCE N° ' . $sequence['SEQUENCEORDRE'] . '</b>');
} elseif ($codeperiode === "T") {
    $pdf->WriteHTMLCell(100, 5, $middle + 100, $y + 5, '<b>TRIMESTRE N° ' . $trimestre['ORDRE'] . '</b>');
} elseif ($codeperiode === "A") {
    $pdf->WriteHTMLCell(100, 5, $middle + 100, $y + 5, '<b>RECAP.ANNUEL : '.$_SESSION['anneeacademique'].'</b>');
} else {
    throw new Exception("CODE PERIODE INEXISTANT");
}
$pdf->Output();

function getPourcentageReussitePourCourbe($idenseignement, $notes) {
    $sup10 = 0;
    $nb = 0;
    foreach ($notes as $n) {
        if ($n['IDENSEIGNEMENT'] === $idenseignement && !empty($n['MOYENNE'])) {
            if ($n['MOYENNE'] >= 10) {
                $sup10++;
            }
            $nb++;
        }
    }
    if ($nb === 0) {
        $nb = 1;
    }
    return sprintf("%.2f", $sup10 / $nb * 100);
}

function getMoyClassePourCourbe($idenseignement, $notes) {
    $nb = 0;
    $sum = 0;
    foreach ($notes as $n) {
        if ($n['IDENSEIGNEMENT'] === $idenseignement && !empty($n['MOYENNE'])) {
            $sum += $n['MOYENNE'];
            $nb++;
        }
    }
    if ($nb === 0) {
        $nb = 1;
    }
    return sprintf("%.2f", $sum / $nb);
}
