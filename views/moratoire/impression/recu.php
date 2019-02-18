<?php

$pdf->SetPrintHeader(false);
# Desactiver les pieds de page
$pdf->SetPrintFooter(false);
$pdf->AddPage();
for ($i = 0; $i < 2; $i++) {
    if($i == 0){
        $x = 15;
        $y = 20;
    }elseif($i == 1){
        $x = 15;
        $y = 110;
    }else{
        $x = 15;
        $y = 200;
    }
    $pdf->Rect($x - 5, $y - 5, 190, 80);
    $logo = SITE_ROOT . "public/img/" . LOGO;

    $pdf->Image($logo, $x, $y - 3, 25, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

# Image de font d'ecran
    $pdf->SetAlpha(0.2);
    $pdf->Image($logo, $x + 67, $y, 50, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
# Remettre l'opacite par defaut
    $pdf->SetAlpha(1);
    $pdf->setFont("Times", "", 10);
    $corps = '<p style="text-align:center;margin:0; padding:0">INSTITUT POLYVALENT WAGUE<br/>
            BP : 5062, Yaound&eacute; / CAMEROUN<br/>
            T&eacute;l : (+237) 697 86 84 99<br/>
            ***************</p>';
   
    $pdf->WriteHTMLCell(0, 0, $x + 5, $y - 3, $corps);
    $pdf->setFont("Times", "", 10);
# Reference
    $reference = '<h2 style="text-align: center; font-size: 15px;">
            <font style="text-decoration: underline">MORATOIRE<br/></font>' . $operation['REFMORATOIRE'] . '</h2>';
    $pdf->WriteHTMLCell(100, 0, $x + 40, $y + 15, $reference);
  
# date de recu
    $pdf->SetFillColor(211, 211, 211);
# $this->SetTextColor(255);
    $pdf->SetDrawColor(128, 0, 0);
    $d = new DateFR($operation['DATEOPERATION']);

    # Classe de l'eleve
    $pdf->WriteHTMLCell(0, 0, $x + 135, $y + 3, "<b>Classe : " . $classe['NIVEAUHTML']."</b>");
    $daterecu = '<b>' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime() . '</b>';
    $pdf->WriteHTMLCell(0, 0, $x + 135, $y + 10, "<b>Montant : # " . moneyString($operation['MONTANT']) . "#</b>", 1, 1, true);
    $pdf->WriteHTMLCell(0, 0, $x + 135, $y + 15, $daterecu);

    $contenu = '<span style="width: 20%; text-align: left">Moratoire accord&eacute; &agrave;: </span> : ' . $operation['NOMEL'] . "  " . $operation['PRENOMEL'] . '<br/>
            <span style="width: 20%; text-align: left">Description:  </span> : 
            <span class="recu_libelle" >' . $operation['DESCRIPTION'] . '</span><br/>
            <span style="width: 20%;text-align: left">MONTANT</span> : ' . moneyString($operation['MONTANT']) . ' <em>fcfa</em>
            <span style="font-size: 12px"><i>(' . enLettre($operation['MONTANT']) . ' franc cfa)</i></span><br/>';
    $pdf->WriteHTMLCell(0, 0, $x, $y + 32, $contenu);
    
    
    $d->setSource($operation['ECHEANCE']);
    $pdf->WriteHTMLCell(0, 0, $x, $y + 47, '<div style="width: 100%;text-align: center; font-weight:bold;">'
            . 'ECHEANCE : ' . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear(). '</div>');

    $infosresp = 'S/C ' . $operation['CIVILITEREP'] . " " . $operation['NOMREP'] . " "
            . $operation['PRENOMREP'] . '<br/>T&eacute;l : ' . $operation['PORTABLEREP'];
    $pdf->WriteHTMLCell(0, 0, $x, $y + 52, $infosresp);

    /* $barrecode = SITE_ROOT . "public/tmp/barcode_upca.png";
      $pdf->Image($barcode, 80, 50, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
      //echo $barcode; */

    #$pdf->write1DBarcode($operation['REFMORATOIRE'], 'C128A', $x + 60, $y + 60, '', 8, 0.4);

   

    $pdf->setFont("Times", "", 8);
    $pdf->WriteHTMLCell(0, 0, $x + 130, $y + 40, "Enreg. par : " . $enregistreur['CIVILITE'].' '.$enregistreur['NOM']);
    $pdf->setFont("Times", "", 7);
     $d->setSource(date("Y-m-d H:i:s", time()));
    $infopersonnel = 'Imprim&eacute; par ' . $personnel['CIVILITE'] . " " . $personnel['NOM'] . ' le '
          .  $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime();
    $pdf->WriteHTMLCell(0, 0, $x, $y + 70, $infopersonnel);
}
$pdf->OutPut();
