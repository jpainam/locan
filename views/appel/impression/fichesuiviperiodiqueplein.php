<?php

$y = PDF_Y;
$pdf->bCertify = false;
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$x = PDF_X;
$middle = PDF_MIDDLE;
$pdf->WriteHTMLCell(0, 0, $middle - 35, $y, '<b>FICHE DE SUIVI PERIODIQUE DES ELEVES</b>');
$pdf->SetFont("Times", "", 8);
$pdf->WriteHTMLCell(0, 5, $middle - 10, $y + 6, '<i>' . $sequence['LIBELLEHTML'] . '</i>');
$pdf->WriteHTMLCell(0, 5, $x, $y + 10, '<b>Enseignant titulaire : </b>');

$pdf->WriteHTMLCell(0, 5, $x + 150, $y + 5, 'Classe : ' . $classe['NIVEAUHTML']);
$pdf->WriteHTMLCell(0, 5, $x + 150, $y + 10, 'Effectif : ' . count($eleves));

$col = [3, 24, 8, 4, 4, 4, 4];

$i = 1;
$d = new DateFR();
$pdf->SetFont("Times", "", 8);
foreach ($eleves as $el) {
    if ($i == 1 || ($i % 40) == 0) {
        if ($i % 40 == 0) {
            $corps .= "</tbody></table>";
            if ($i > 77) {
                $pdf->WriteHTMLCell(190, 5, $x + 95, $y + 20, $corps);
                $pdf->AddPage();
            } else {
                $pdf->WriteHTMLCell(190, 5, 5, $y + 20, $corps);
            }
        }
        $corps = '<table cellpadding = "2"><thead><tr style="font-weight:bold;font-size:6px;text-align:center">'
                . '<th border="0.5" width ="' . $col[0] . '%">N°</th>'
                . '<th border="0.5" width ="' . $col[1] . '%">Nom et Pr&eacute;noms</th>'
                . '<th border="0.5" width ="' . $col[2] . '%">D.Naiss</th>'
                . '<th border="0.5" width ="' . $col[3] . '%">T.Ab</th>'
                . '<th border="0.5" width ="' . $col[4] . '%">Ab.J</th>'
                . '<th border="0.5" width ="' . $col[5] . '%">Cons</th>'
                . '<th border="0.5" width ="' . $col[6] . '%">Decis°</th></tr></thead>'
                . '<tbody>';
    }
    $d->setSource($el['DATENAISS']);
    if (!empty($el['DATENAISS']) && $el['DATENAISS'] !== "0000-00-00") {
        $datenaiss = $d->getDate() . "/" . $d->getMonth() . "/" . $d->getYear();
    } else {
        $datenaiss = "";
    }
    $absence = getAbsenceElevePeriodique($el['IDELEVE'], $absences);
    $abs = $just = $cons = $decis = "";
    if (!is_null($absence)) {
        $abs = $absence['ABSENCE'];
        $just = $absence['JUSTIFIER'];
        $cons = $absence['CONSIGNE'];
        $decis = $absence['DECISION'];
    } 
    $corps .= '<tr>'
            . '<td width ="' . $col[0] . '%" border="0.5">' . $i . '</td>'
            . '<td width ="' . $col[1] . '%" border="0.5">' . $el['NOM'] . ' ' . $el['PRENOM'] . '</td>'
            . '<td width ="' . $col[2] . '%"  border="0.5">' . $datenaiss . '</td>'
            . '<td width ="' . $col[3] . '%" border="0.5" align="center">' . ($abs == 0 ? "" : $abs) . '</td>'
            . '<td width ="' . $col[4] . '%" border="0.5" align="center">' . ($just == 0 ? "" : $just) . '</td>'
            . '<td width ="' . $col[5] . '%" border="0.5" align="center">' . ($cons == 0 ? "" : $cons) . '</td>'
            . '<td width ="' . $col[6] . '%" border="0.5" align="center">' . ($decis == 0 ? "" : $decis) . '</td></tr>';
    $i++;
}
if ($i > 78) {
    $corps .= "</tbody></table>";
    $pdf->WriteHTMLCell(190, 5, 5, $y - 20, $corps);
} elseif ($i < 40) {
    $corps .= "</tbody></table>";
    $pdf->WriteHTMLCell(190, 5, 5, $y + 20, $corps);
} else {
    $corps .= "</tbody></table>";
    $pdf->WriteHTMLCell(190, 5, $x + 95, $y + 20, $corps);
}
$pdf->Output();

function getAbsenceElevePeriodique($ideleve, $absences) {
    foreach ($absences as $abs) {
        if ($abs['ELEVE'] === $ideleve) {
            return $abs;
        }
    }
    return null;
}
