<?php
$pdf->isLandscape = true;

$pdf->setPageOrientation('L');
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


$titre = '<h4 style = "text-align:center"> PLANNING DES ACTIVITES PEDAGOGIQUES DU ' . $trimestre . '<br> ANNEE SCOLAIRE' . $annee . ' </h4>';
$pdf->WriteHTMLCell(0, 0, 0, 60, $titre);
$titre = '<br><p>(arrete interministériel N°044/B1/1464/MINEDUB/MINESEC/du 06 juin 2013)</p>';
$pdf->WriteHTMLCell(0, 0, 70, 70, $titre);
$pdf->SetFont("Times", '', 12);
$n = 1;
$periodes = '21/04/2015';
$activites = 'Rentree du 3 eme treimestre';
$objectifs = 'Reprendre les cours';
$ressources = 'eleves enseignants';
$responsables = 'Proviseur';
$dispositif = 'fiche d\'appel';
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			    <td border="0.5"  width ="30px">N°</td>
			    <td border="0.5"  width ="100px">PERIODES </td>
				<td border="0.5"  width ="100px">ACTIVITES</td>
				<td border="0.5"  width ="200px">OBJECTIFS</td>
				<td border="0.5"  width ="100px">RESSOURCES</td>
				<td border="0.5"  width ="100px">RESPONSABLES</td>
				<td border="0.5"  width ="110px">DISPOSITIF<br>D\'EVALUATION</td></tr>';

for ($j = 1; $j <= 2; $j++) {
    $corps .='<tr>
			     <td border="0.5">' . $n . '</td>
			     <td border="0.5">' . $periodes . '</td>
				 <td border="0.5">' . $activites . '</td>
				 <td border="0.5">' . $objectifs . '</td>
				 <td border="0.5">' . $ressources . '</td>
				 <td border="0.5">' . $responsables . '</td>
				 <td border="0.5">' . $dispositif . '</td>
			   </tr>';
}

$corps .= '</table>';
$pdf->WriteHTMLCell(0, 0, 10, 100, $corps);

$titre = '<h4> AMPLIATIONS:</h4>';
$pdf->WriteHTMLCell(0, 0, 25, 160, $titre);
$titre = '<p><ul>
               <li>sous-prefet/N-E</li>
			   <li>DDES/HAUTE-SANAGA</li>
			   <li>CENSEURS</li>
			   <li>S.G</li>
			   <li>PROFESSEURS</li>
			   <li>AFFICHAGES</li>
			   <li>ARCHIVES</li>
              </ul> :</p>';
$date = '11/12/11';
$pdf->WriteHTMLCell(0, 0, 25, 160, $titre);
$titre = '<p>Nanga-Eboko, le: ' . $date . '</p>';
$pdf->WriteHTMLCell(0, 0, 200, 160, $titre);
$titre = '<p>LE PROVISEUR :</p>';
$pdf->WriteHTMLCell(0, 0, 200, 170, $titre);




// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('planningactivitepedagogique.pdf', 'I');
