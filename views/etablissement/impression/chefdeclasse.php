<?php

$pdf->AddPage();
$pdf->SetPrintHeader(false);
$annee = '2014/2015';
$trimestre = 1;
$sequence = 1;
$y = 40; //FIRST_TITLE;
$x = 10;
$classe = '6m';
$nomprenom_chefclass = 'atangana';
$nomprenom_souschefclass = 'olomo';
$titre = '<p style = "text-align:center"><h4 > LISTE DES CHEFS DE CLASSES  </h4>';
$titre .='<br/><b>ann&eacute;e scolaire :</b>' . $annee . '</p>';
$pdf->WriteHTMLCell(0, 0, $x, $y, $titre);
$pdf->SetFont("Times", '', 7);
$titre = '<br><b>SQUENCE N°:</b>' . $sequence . '</p>';
$pdf->WriteHTMLCell(0, 0, $x + 10, $y + 5, $titre);

$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			  
			    <td border="0.5"  width ="4%">N°</td>
			    <td border="0.5"  width ="11%">CLASSES </td>
				<td border="0.5"  width ="45%">Nom(s) et prénom(s) du chef</td>
				<td border="0.5"  width ="40%">Nom(s) et prénom(s) du sous chef</td>
			</tr>';

for ($j = 1; $j <= 2; $j++) {
    $corps .='<tr>
			     <td border="0.5">' . $j . '</td>
			     <td border="0.5">' . $classe . '</td>
				 <td border="0.5">' . $nomprenom_chefclass . '</td>
				 <td border="0.5">' . $nomprenom_souschefclass . '</td>
			  </tr>';
}
$corps .= '</table>';
$pdf->WriteHTMLCell(0, 0, $x, $y + 30, $corps);

$pdf->Output();
