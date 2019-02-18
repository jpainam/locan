<?php

//$pdf->setPageOrientation('L');
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$annee = '2014/2015';
$trimestre = 1;
$sequence = 1;
$y = 0;
$x = 0;
$pavj = 0;
$gross = 0;
$numero = 0;
$classe = '6m';

//writeHTMLCell(  $w,   $h,   $x,   $y,   $html = '',   $border,   $ln,   $fill = false,   $reseth = true,   $align = '',   $autopadding = true) 


$titre = '<h4 style = "text-align:center"> DISCIPLINE PERSONNELS ADMINISTRATIFS </h4>';

$pdf->WriteHTMLCell(0, 0, 0, 60, $titre);
$pdf->SetFont("Times", '', 7);
$titre = '<p><b>ANNEE SCOLAIRE :</b>' . $annee . '</p>';
$titre .='<br><p><b>SQUENCE N°:</b>' . $sequence . '</p>';
$pdf->WriteHTMLCell(0, 0, 250, 60, $titre);
$matiere = 'MATHEMATIQUES';
$n = 1;
$nom = 'atangana';
$nbrjour = 2;
$nbrabnonjust = 2;
$nbrabjust = 2;
$pourcentageassiduite = 2;
$ponctualite = 2;
$pourponctualite = 2;
$fonction = 'PROVISEURS';
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			    <td border="0.5"  width ="30px">N°</td>
			    <td border="0.5"  width ="100px">NOMS ET PRENOMS </td>
				<td border="0.5"  width ="50px">FONCTION</td>
				<td border="0.5"  width ="50px">Nbr. jour. <br>Travail</td>
				<td border="0.5"  width ="50px">Nbr.<br>A.N.J/J</td>
				<td border="0.5"  width ="50px">Nbr.<br>A.J/J</td>
				<td border="0.5"  width ="50px">%ASSIDUITE</td>
				<td border="0.5"  width ="60px">PONCTUALITE</td>
				<td border="0.5"  width ="80px">%PONCTUALITE</td>
             </tr>';

for ($j = 1; $j <= 2; $j++) {
    $corps .='<tr>
			     <td border="0.5">' . $n . '</td>
			     <td border="0.5">' . $nom . '</td>
				 <td border="0.5">' . $fonction . '</td>
				 <td border="0.5">' . $nbrjour . '</td>
				 <td border="0.5">' . $nbrabnonjust . '</td>
				 <td border="0.5">' . $nbrabjust . '</td>
				 <td border="0.5">' . $pourcentageassiduite . '</td>
				 <td border="0.5">' . $ponctualite . '</td>
				 <td border="0.5">' . $pourponctualite . '</td>
			   </tr>';
}

$corps .= '</table>';
$pdf->WriteHTMLCell(0, 0, 5, 80, $corps);
// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('disciplinepersonneladministratif.pdf', 'I');
