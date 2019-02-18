<?php

$pdf->AddPage();
$pdf->SetPrintHeader(false);
$y = FIRST_TITLE;
$x = 0;
$nomProviseur = 'MINTOM BASOUQUI';
$pronomProviseur = 'GILBER';
$etablisment = 'Lycee clasique';
$ville = 'Nanga Eboko';
$nomeleve = 'Atangana';
$prenomeleve = 'antoine';
$datenaissanceEleve = '11/08/1990';
$lieuNaissance = 'Nkoambang';
$arondisemntEleve = 'Nanga Eboko';
$departementEleve = 'Haute sanaga';
$nomPere = 'Avom Ndze ';
$prenomPere = 'jean celestin Clotaire';
$nomMere = 'Binga ';
$prenomMere = 'valentine christine';
$classeEleve = '6m';
$matriculeEleve = 'CCC89865579';
$anneeScolaire = '2015/2016';
$titre = '<h4 style = "text-align:center">CERTIFICAT  DE  SCOLARITE </h4>';
$pdf->WriteHTMLCell(0, 0, $x, $y + 20, $titre);
$pdf->SetFont("Times", '', 12);
$titre = '<br><p>Je soussign&eacute;,……………' . $nomProviseur . '……' . $pronomProviseur . '………………………<br/><br/>
      Proviseur du ……………' . $etablisment . ' de ' . $ville . ',<br/><br/>
      Certifie que le, la nomm&eacute;(e.)………' . $nomeleve . '……' . $prenomeleve . '……………………………………….<br/><br/>   
      N&eacute;(e) le……………' . $datenaissanceEleve . '……………. A………' . $lieuNaissance . '………………………<br/><br/>         
      Arrondissement :…………' . $arondisemntEleve . '……d&eacute;partement : ……' . $departementEleve . '………………….<br/><br/>
      Fils ou fille de :……' . $nomPere . '……' . $prenomPere . '……………..<br/> <br/>
      Et de :…………………' . $nomMere . '…………' . $prenomMere . '………………………….<br/><br/> 
      Est r&eacute;guli&egrave;rement inscrit(e)  dans mon &eacute;tablissement en classe  de……' . $classeEleve . '……<br/> <br/>
      Sous le matricule…' . $matriculeEleve . '…. . Au cours de l’Ann&eacute;e scolaire…' . $anneeScolaire . '……...<br/><br/>    
      En foi de quoi le pr&eacute;sent certificat lui est d&eacute;livr&eacute; pour servir et valoir ce que de droit.<br/><br/> 
</p>';
$pdf->WriteHTMLCell(0, 0, $x + 20, $y + 30, $titre);
$date = date('d/m/Y');
$titre = '<p>Nanga-Eboko, le: ' . $date . '</p>';
$pdf->WriteHTMLCell(0, 0, $x + 130, $y + 150, $titre);
$titre = '<p><b>Le Proviseur ,</b></p>';
$pdf->WriteHTMLCell(0, 0, $x + 130, $y + 160, $titre);




// reset pointer to the last page
$pdf->Output('planningactivitepedagogique.pdf', 'I');
