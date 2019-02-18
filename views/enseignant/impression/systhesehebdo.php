<?php
//$pdf->setPageOrientation('L');
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$annee='2014/2015';
$trimestre=1;
$sequence =1;
$y=0;
$x=0;
$pavj=0;
$gross=0;
$numero=0;
$classe='6m';

//writeHTMLCell(  $w,   $h,   $x,   $y,   $html = '',   $border,   $ln,   $fill = false,   $reseth = true,   $align = '',   $autopadding = true) 


$titre ='<h4 style = "text-align:center"> SYNTHESE HEBDOMADAIRE PROFESSEURS </h4>'; 

$pdf->WriteHTMLCell(0, 0, 0, 60 , $titre);
$pdf->SetFont("Times", '', 7); 
$titre ='<p><b>ANNEE SCOLAIRE :</b>'.$annee.'</p>';  
$titre .='<br><p><b>SQUENCE N°:</b>'.$sequence.'</p>';
$pdf->WriteHTMLCell(0, 0, 250, 60 , $titre);
$matiere='MATHEMATIQUES';
$n=1;
$nom[0] = "";
$nom[1]='Ainam Jean - Paul';
$nom[2] = 'Armel Kadje';
$heuresdue=2;
$heuresnonfait=2;
$pourcentageassiduite=2;
$ponctualite=2;
$pourponctualite=2;
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			    <td border="0.5"  width ="50px">N°</td>
			    <td border="0.5"  width ="100px">NOMS ET PRENOMS </td>
				<td border="0.5"  width ="50px">heures <br>Dues</td>
				<td border="0.5"  width ="50px">heures <br>Non Faites</td>
				<td border="0.5"  width ="50px">%ASSIDUITE</td>
				<td border="0.5"  width ="50px">PONCTUALITE</td>
				<td border="0.5"  width ="50px">%PONCTUALITE</td>
             </tr>';
			 
for ($j = 1; $j <= 2; $j++) {	
	 $corps .='<tr>
			     <td border="0.5">'.$j.'</td>
			     <td border="0.5">'.$nom[$j].'</td>
				 <td border="0.5">'.$heuresdue.'</td>
				 <td border="0.5">'.$heuresnonfait * $j.'</td>
				 <td border="0.5">'.$pourcentageassiduite * $j.'</td>
				 <td border="0.5">'.$ponctualite * $j.'</td>
				 <td border="0.5">'.$pourponctualite  * $j.'</td>
			   </tr>';
			 }
	
$corps .= '</table>';			
$pdf->WriteHTMLCell(0, 0, 5, 80 , $corps);

$titre .='<p>plus fort % abscence :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);
$titre .='<p>plus faible :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);
$titre .='<p>Assiduite General :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);
$titre .='<p>% ponctualite :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);
$titre .='<p>plus fort % ponctualite :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);
$titre .='<p>plus faible % ponctualite :</p>';
$pdf->WriteHTMLCell(0, 0, 25, 160 , $titre);







// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('systhesehedodesprofesseurs.pdf', 'I');		 