<?php

$pdf->AddPage();
$pdf->SetPrintHeader(false);
$y = PDF_Y;
$x = PDF_X;
$middle = PDF_MIDDLE;
$pdf->setFont("Times", '', 9);
$titre = '<b>LISTE DES NOTES DE L\'ELEVE : <br/>' . $eleve['NOM'] . ' ' . $eleve['PRENOM'] . '</b>';
$pdf->WriteHTMLCell(0, 5, $middle - 25, $y, $titre);

$pdf->WriteHTMLCell(100, 100, 150, $y, '<b>Ann&eacute;e Acad. ' . $_SESSION['anneeacademique'].'</b>');
$cols[0] = 10;
$cols[1] = 20;
$cols[2] = 20;
$cols[3] = 10;
$cols[4] = 7;
$cols[5] = 20;
$pdf->setFont("Times", '', 7);

$corps = '<table cellpadding="2" border="1"><thead>
    <tr  border ="1"   style="font-weight:bold"  >
        <td border="1"  width ="' . $cols[0] . '%">S&eacute;quences</td>
        <td border="1"  width ="' . $cols[1] . '%">Mati&egrave;res</td>
        <td border="1"  width ="' . $cols[2] . '%"  >Description</td>
        <td border="1"  width ="' . $cols[3] . '%" >Date</td>
        <td border="1"  width ="' . $cols[4] . '%" >Note</td>
        <td border="1"  width ="' . $cols[5] . '%" >Appr&eacute;ciation</td>
      </tr></thead><tbdoy>';
foreach ($notes as $n) {
    $d = new DateFR($n['DATEDEVOIR']);
    $corps .= '<tr><td border="1"  width ="' . $cols[0] . '%">' . $n['LIBELLEHTML'] . "</td>"
            . '<td border="1"  width ="' . $cols[1] . '%">' . $n['BULLETIN'] . "</td>"
            . '<td border="1"  width ="' . $cols[2] . '%">' . $n['DESCRIPTION'] . '</td>'
            . '<td border="1"  width ="' . $cols[3] . '%">' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear(2) . "</td>"
            . '<td align="right" border="1"  width ="' . $cols[4] . '%">' . $n['NOTE'] . "</td>"
            . '<td border="1"  width ="' . $cols[5] . '%">' . getAppreciations($n['NOTE']) . '</td></tr>';
}
$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, $x + 10, $y + 10, $corps);
$pdf->Output();
