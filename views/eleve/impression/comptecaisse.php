<?php
$pdf->AddPage();
$pdf->SetPrintHeader(false);

$y = Y_PDF;
$x = X_PDF;

$titre = '<h5>' . strtoupper($compte['NOM'] . ' ' . $compte['PRENOM']) . ' </h5>';
$pdf->WriteHTMLCell(0, 0, $x, $y + 10, $titre);

$pdf->WriteHTMLCell(0, 0, PDF_MIDDLE - 30, $y, "<b>RELEVE DE COMPTE</b>");
$d = new DateFR();
$pdf->SetFontSize(9);
$pdf->WriteHTMLCell(50, 0, 155, $y - 10, "<p>N° compte : " . $compte['CODE'] . "<br/>Date g&eacute;n&eacute;ration &eacute;tat : " .
        $d->getDate() . "-" . $d->getMois(3) . "-" . $d->getYear(2) . "<br/>"
        . "P&eacute;riode : " . $anneeacademique . "</p>");

$pdf->SetFont("Courier", '', 7);
$col[0] = 12;
$col[1] = 15;
$col[2] = 15;
$col[3] = 30;
$col[4] = 10;
$col[5] = 10;
$col[6] = 12;

$corps = '<table cellpadding="2"><thead>
              <tr style="font-weight:bold; border-top: 1px solid #000;border-bottom: 1px solid #000;">
			        <th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000;" 
                                width ="' . $col[0] . '%" >Date<br/> transaction</th>
				<th align="center" valign="bottom" style="border-top: 1px solid #000;border-bottom: 1px solid #000" width ="' . $col[1] . '%">R&eacute;f.Caisse</th>
				<th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000;vertical-align:bottom" width ="' . $col[2] . '%">R&eacute;f. transaction</th>
				<th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000" width ="' . $col[3] . '%">Libell&eacute;</th>
				<th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000" width ="' . $col[4] . '%">D&eacute;bit</th>
                                <th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000" width ="' . $col[5] . '%">Cr&eacute;dit</th>
				<th align="center" style="border-top: 1px solid #000;border-bottom: 1px solid #000" width ="' . $col[6] . '%">Balance</th></tr></thead><tbody>';
$balance = 0;
$month = 0;
$totalperiode = 0;
$corps .= '<tr><td align="right" colspan="7" width ="' . ($col[0] + $col[1] + $col[2] + $col[3] + $col[4] + $col[5] + $col[6]) . '%">0,00</td></tr>';
foreach ($operations as $op) {
    if ($month != date("n", strtotime($op['DATETR'])) && $month != 0) {

        $corps .= '<tr><td colspan="3" width ="' . ($col[0] + $col[1] + $col[2]) . '%"></td>'
                . '<td style="border-top: 1px solid #000;border-bottom: 1px solid #000;font-weight:bold;" '
                . 'width ="' . $col[3] . '%">0' . $month . "/" . date("Y", strtotime($op['DATETR'])) . " Total pour p&eacute;riode : </td>";
        $corps .= '<td align="right" style="border-top: 1px solid #000;border-bottom: 1px solid #000;" width ="' . $col[4] . '%">';
        if ($totalperiode < 0) {
            $corps .= moneyString(abs($totalperiode));
        }
        $corps .= '</td><td align="right" style="border-top: 1px solid #000;border-bottom: 1px solid #000;" width ="' . $col[5] . '%">';
        if ($totalperiode >= 0) {
            $corps .= moneyString($totalperiode);
        }
        $corps .= '</td>'
                . '<td width ="' . $col[6] . '%"></td></tr>';
        $totalperiode = 0;
    }

    if ($op['TYPE'] == "C") {
        $balance += $op['CREDIT'];
        $totalperiode += $op['CREDIT'];
    } else {
        $balance -= $op['DEBIT'];
        $totalperiode -= $op['DEBIT'];
    }

    $d->setSource($op['DATETR']);

    $corps .='<tr>
		<td width ="' . $col[0] . '%" >' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . '</td>
                <td width ="' . $col[1] . '%" >' . $op['REFCAISSE'] . '</td>
                <td width ="' . $col[2] . '%" >' . $op['REFTRANSACTION'].'/' .$op['NIVEAUHTML']. '</td>
                <td width ="' . $col[3] . '%" >' .$op['LIBELLE'] . '</td>
                <td align="right" width ="' . $col[4] . '%" >' . moneyString($op['DEBIT']) . '</td>
                <td align="right" width ="' . $col[5] . '%" >' . moneyString($op['CREDIT']) . '</td>
                <td align="right" width ="' . $col[6] . '%" >' . moneyString(abs($balance));
    if ($balance > 0) {
        $corps .= " cr";
    }
    $corps .= '</td></tr>';


    $month = date("n", strtotime($op['DATETR']));
}
$corps .='<tr style="font-weight:bold">
            <td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;">' . $compte['CODE'] . '</td>
                <td colspan="4" align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total pour compte </b></td>
                <td align="right" style="border-top:1px solid #000;border-bottom:1px solid #000;" >' . moneyString(abs($balance));
if ($balance > 0) {
    $corps .= " cr";
}
$corps .= '</td></tr>';

$corps .= '</tbody></table>';
$pdf->WriteHTMLCell(0, 5, $x, $y + 20, $corps);
$pdf->lastPage();
$pdf->Output();
