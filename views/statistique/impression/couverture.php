<?php
$pdf->setPageOrientation('L');
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$matiere='MATHS';
$annee='2014/2015';
$trimestre=1;
$sequence =1;
$y = FIRST_TITLE;
$x = 5;
$titre ='<h4 style = "text-align:center"> FICHE DE COLLECTE DES DONNEES RELATIVES AUX EVALUATIONS <br> DES TAUX DE COUVERTURE DES PROGRAMMES ET HEURES<br>D\' ENSEIGNEMENT PAR ETABLISSEMENT (AP)</h4>'; 

$pdf->WriteHTMLCell(0, 0, 0, $y + 10 , $titre);
$pdf->SetFont("Times", '', 7);
$titre ='<p><b>DISCIPLINE :</b>'.$matiere.'</p>'; 
$pdf->WriteHTMLCell(0, 0, $x, $y + 20 , $titre);
$titre ='<p><b>ANNEE SCOLAIRE :</b>'.$annee; 
$titre .='<br/><b>TRIMESTRE :</b>'.$trimestre; 
$titre .='<br/><b>SQUENCE N°:</b>'.$sequence.'</p>';
$pdf->WriteHTMLCell(0, 0, 240, $y + 20 , $titre);
//  sup &gt   inf &lt   é &eacute; è &egrave; ;
$corps = '<table style="text-align:center" cellpadding="2">
              <tr style="font-weight:bold">
			  
			    <td border="0.5" rowspan="3" width ="50px">classe</td>
			    <td border="0.5" rowspan="3" width ="100px">Nom du <br>professeur</td>
				<td border="0.5" colspan="4" width ="90px">Nombre de leçons <br>Pr&eacute;vues</td>
				<td border="0.5" colspan="4" width ="90px">Nombre de leçons <br>Faites</td>
				<td border="0.5" colspan="4" width ="90px">Pourcentage</td>
				<td border="0.5" colspan="4" width ="90px">Nombre d\'heures <br>Pr&eacute;vues</td>
				<td border="0.5" colspan="4" width ="100px">Nombre d\'heures <br>Faites</td>
				<td border="0.5" colspan="4" width ="100px">Pourcentage <br> D\'assiduit&eacute;</td>
			    <td border="0.5" colspan="4" width ="100px">Nombre d\'heures <br> De rattrapage</td>
			  </tr>
              <tr>';
		for($i=1;$i<=7;$i++){		   
           $corps .= '<td border="0.5" colspan="2">par rapp.<br>seq</td>
				<td border="0.5" colspan="2">par rapp.<br>ann.</td>';
				}	   
		$corps .=  '</tr>			  
			   <tr>'; 
		for($i=1;$i<=14;$i++){		   
           $corps .= '<td border="0.5">theo</td>
			         <td border="0.5">prat</td>';
				}	  
		    $corps .= '</tr>' ;
			
                        $nlpst=4 ; // nombre de lecons prevues par rapport a la sequence theorique
			$nlpsp =6 ; // nombre de lecons prevues par rapport a la sequence pratique 
			$nlpat =4 ; // nombre de lecons prevues par rapport a l'annee theorique
			$nlpap=4 ;  // nombre de lecons prevues par rapport a l'annee pratique
			
			$nlfpst=4 ; // nombre de lecons faite par rapport a la sequence theorique
			
			$nlfpsp =4 ;// nombre de lecons faite par rapport a la sequence pratique
			$nlfpat =4 ;// nombre de lecons faite par rapport a la annee theorique
			$nlfpap =4 ;// nombre de lecons faite par rapport a la annee pratique
			$plst=4 ;   // pourcentage  de lecon par rapport a la sequence theorique
			$plsp =4 ; // pourcentage de lecon par rapport a la sequence pratique
			$plat=4 ;   // pourcentage de lecon par rapport a l annee theorique 
			$plap=4 ;  // pourcentage de  lecon par rapport a l annee pratique
			$nhpst=4 ; // nombre d'heures prevues par rapport a sequence theorique
			$nhpsp=4 ; // nombre d'heures prevues par rapport a sequence pratique
			$nhpat=4 ; // nombre d'heures prevues par rapport a annee theorique
			$nhpap=4 ; // nombre d'heures prevues par rapport a annee pratique
			$nhfst=4 ; // nombre d'heures faite par rapport a sequence theorique
			$nhfsp=4 ; // nombre d'heures faite par rapport a sequence pratique
			$nhfat=4 ; // nombre d'heures faite par rapport a annee theorique
			$nhfap=4 ; // nombre d'heures faite par rapport a annee pratique
			$past=4 ;  // pourcentage d' assiduite par rapport a la sequence theorique
			$pasp=4 ;  // pourcentage d' assiduite par rapport a la sequence pratique
			$paat =4 ; // pourcentage d' assiduite par rapport a la annee theorique
			$paap=4 ;  // pourcentage d' assiduite par rapport a la annee pratique
			$nhrst=4 ;  // nombre de heures de rattrapage par rapport sequence theorique
			$nhrsp=4 ;  // nombre de heures de rattrapage par rapport sequence pratique
			$nhrat=4 ;  // nombre de heures de rattrapage par rapport a annee theorique
			$nhrap=4 ;  // nombre de heures de rattrapage par rapport a annee pratique
			
			
			                        //TOTAL
			
			
			$nlpst_T=0;
			$nlpsp_T=0;
			
			$nlpat_T=0 ; // nombre de lecons prevues par rapport a l'annee theorique  TOTAL
			$nlpap_T=0;  // nombre de lecons prevues par rapport a l'annee pratique
			
			$nlfpst_T=0 ; // nombre de lecons faite par rapport a la sequence theorique
			
			$nlfpsp_T=0 ;// nombre de lecons faite par rapport a la sequence pratique
			$nlfpat_T=0 ;// nombre de lecons faite par rapport a la annee theorique
			$nlfpap_T=0 ;// nombre de lecons faite par rapport a la annee pratique
			$plst_T=0 ;   // pourcentage  de lecon par rapport a la sequence theorique
			$plsp_T =0 ; // pourcentage de lecon par rapport a la sequence pratique
			$plat_T=0 ;   // pourcentage de lecon par rapport a l annee theorique 
			$plap_T=0;  // pourcentage de  lecon par rapport a l annee pratique
			$nhpst_T=0 ; // nombre d'heures prevues par rapport a sequence theorique
			$nhpsp_T=0 ; // nombre d'heures prevues par rapport a sequence pratique
			$nhpat_T=0 ; // nombre d'heures prevues par rapport a annee theorique
			$nhpap_T=0; // nombre d'heures prevues par rapport a annee pratique
			$nhfst_T=0 ; // nombre d'heures faite par rapport a sequence theorique
			$nhfsp_T=0 ; // nombre d'heures faite par rapport a sequence pratique
			$nhfat_T=0 ; // nombre d'heures faite par rapport a annee theorique
			$nhfap_T=0 ; // nombre d'heures faite par rapport a annee pratique
			$past_T=0 ;  // pourcentage d' assiduite par rapport a la sequence theorique
			$pasp_T=0 ;  // pourcentage d' assiduite par rapport a la sequence pratique
			$paat_T=0; // pourcentage d' assiduite par rapport a la annee theorique
			$paap_T=0 ;  // pourcentage d' assiduite par rapport a la annee pratique
			$nhrst_T=0 ;  // nombre de heures de rattrapage par rapport sequence theorique
			$nhrsp_T=0;  // nombre de heures de rattrapage par rapport sequence pratique
			$nhrat_T=0 ;  // nombre de heures de rattrapage par rapport a annee theorique
			$nhrap_T=0 ;  // nombre de heures de rattrapage par rapport a annee pratique
			
			$nomProf_T=0 ;//nombre de professeurs
			
			
			
			
			
			
			
			$classe='6M';
			$nomProf='MBOUTOUM';
		
			
			
	for ($j = 1; $j <= 2; $j++) {	
	 $corps .='<tr>
			     <td border="0.5">'.$classe.'</td>
			     <td border="0.5">'.$nomProf.'</td>
				 <td border="0.5">'.$nlpst.'</td>
			     <td border="0.5">'.$nlpsp.'</td>
				 <td border="0.5">'.$nlpat.'</td>
			     <td border="0.5">'.$nlpap.'</td>
				 <td border="0.5">'.$nlfpst.'</td>
			     <td border="0.5">'.$nlfpsp.'</td>
				 <td border="0.5">'.$nlfpat.'</td>
			     <td border="0.5">'.$nlfpap.'</td>
				 <td border="0.5">'.$plst.'</td>
			     <td border="0.5">'.$plsp.'</td>
				 <td border="0.5">'.$plat.'</td>
			     <td border="0.5">'.$plap.'</td>
				 <td border="0.5">'.$nhpst.'</td>
			     <td border="0.5">'.$nhpsp.'</td>
				 <td border="0.5">'.$nhpat.'</td>
			     <td border="0.5">'.$nhpap.'</td>
				 <td border="0.5">'.$nhfst.'</td>
			     <td border="0.5">'.$nhfsp.'</td>
				 <td border="0.5">'.$nhfat.'</td>
			     <td border="0.5">'.$nhfap.'</td>
				 <td border="0.5">'.$past.'</td>
			     <td border="0.5">'.$pasp.'</td>
				 <td border="0.5">'.$paat.'</td>
			     <td border="0.5">'.$paap.'</td>
				 <td border="0.5">'.$nhrst.'</td>
			     <td border="0.5">'.$nhrsp.'</td>
				 <td border="0.5">'.$nhrat.'</td>
			     <td border="0.5">'.$nhrap.'</td>
				  
			  </tr>';
			    $nlpst_T+=$nlpst;
				$nlpsp_T+=$nlpsp;
				$nlpat_T+=$nlpat; 
			    $nlpap_T+=$nlpap ;  
			    $nlfpst_T+=$nlfpst ; 
			    $nlfpsp_T+=$nlfpsp ;
			    $nlfpat_T+=$nlfpat ;
			    $nlfpap_T+=$nlfpap ;
			    $plst_T+=$plst ;   
			    $plsp_T+=$plsp ; 
			    $plat_T+=$plat ;   
			    $plap_T+=$plap ;  
			    $nhpst_T+=$nhpst ; 
			    $nhpsp_T+=$nhpsp ; 
			    $nhpat_T+=$nhpat ; 
			    $nhpap_T+=$nhpap ; 
			    $nhfst_T+=$nhfst ; 
			    $nhfsp_T+=$nhfsp ; 
			    $nhfat_T+=$nhfat ; 
			    $nhfap_T+=$nhfap ; 
			    $past_T+=$past ;  
			    $pasp_T+=$pasp ;  
			    $paat_T+=$paat; 
			    $paap_T+=$paap;  
			    $nhrst_T+=$nhrst ;  
			    $nhrsp_T+=$nhrsp;  
			    $nhrat_T+=$nhrat ;  
			    $nhrap_T+=$nhrap ;  	
			    $nomProf_T++;
			}
			
			
			
			
		$corps .='<tr>
			     <td border="0.5"><b>TOTAL</b></td>
			     <td border="0.5">'.$nomProf_T.'</td>
				 <td border="0.5">'.$nlpst_T.'</td>
			     <td border="0.5">'.$nlpsp_T.'</td>
				 <td border="0.5">'.$nlpat_T.'</td>
			     <td border="0.5">'.$nlpap_T.'</td>
				 <td border="0.5">'.$nlfpst_T.'</td>
			     <td border="0.5">'.$nlfpsp_T.'</td>
				 <td border="0.5">'.$nlfpat_T.'</td>
			     <td border="0.5">'.$nlfpap_T.'</td>
				 <td border="0.5">'.$plst_T.'</td>
			     <td border="0.5">'.$plsp_T.'</td>
				 <td border="0.5">'.$plat_T.'</td>
			     <td border="0.5">'.$plap_T.'</td>
				 <td border="0.5">'.$nhpst_T.'</td>
			     <td border="0.5">'.$nhpsp_T.'</td>
				 <td border="0.5">'.$nhpat_T.'</td>
			     <td border="0.5">'.$nhpap_T.'</td>
				 <td border="0.5">'.$nhfst_T.'</td>
			     <td border="0.5">'.$nhfsp_T.'</td>
				 <td border="0.5">'.$nhfat_T.'</td>
			     <td border="0.5">'.$nhfap_T.'</td>
				 <td border="0.5">'.$past_T.'</td>
			     <td border="0.5">'.$pasp_T.'</td>
				 <td border="0.5">'.$paat_T.'</td>
			     <td border="0.5">'.$paap_T.'</td>
				 <td border="0.5">'.$nhrst_T.'</td>
			     <td border="0.5">'.$nhrsp_T.'</td>
				 <td border="0.5">'.$nhrat_T.'</td>
			     <td border="0.5">'.$nhrap_T.'</td>
				  
			  </tr>';			
			
$corps .= '</table>';						
$pdf->WriteHTMLCell(0, 0, 5, $y + 35 , $corps);
$corps='Nanga Eboko le :';
$pdf->WriteHTMLCell(0, 0, 230, $y +115  , $corps);
$corps='OBSERVATION  DE L AP';
$pdf->WriteHTMLCell(0, 0, $x+5, $y +130 , $corps);
$corps='OBSERVATION  DU CENSEUR';
$pdf->WriteHTMLCell(0, 0, $x+110, $y +130, $corps);
$corps='OBSERVATION  DU PROVISEUR';
$pdf->WriteHTMLCell(0, 0, 230, $y +130 , $corps);
// reset pointer to the last page
$pdf->Output();