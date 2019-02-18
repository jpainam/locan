<?php

$pdf->isLandscape = true;
$pdf->setPageOrientation('L');
$y = FIRST_TITLE;
$pdf->AddPage();
//Titre du PDF
$anneeScolaire = '2014 - 2015';
$titre = '<p style = "text-decoration:underline  text-align:center">FICHIER DES PERSONNELS <br/>Année scolaire ' . $anneeScolaire . '</p>';
$pdf->WriteHTMLCell(0, 50, 85, $y, $titre);

$col[0] = 6;
$col[1] = 6;
$col[2] = 3;
$col[3] = 5;
$col[4] = 2;
$col[5] = 8;
$col[6] = 4;
$col[7] = 2;
$col[8] = 6;
$col[9] = 4;
$col[10] = 6;
$col[11] = 4;
$col[12] = 6;
$col[13] = 4;
$col[14] = 6;
$col[15] = 2;
$col[16] = 3;
$col[17] = 4;
$col[18] = 2;
$col[19] = 3;
$col[20] = 4;
$col[21] = 3;
$col[22] = 4;
$col[23] = 4;
$col[24] = 4;

//Corps du PDF
$corps = '<table border = "1" cellpadding = "2" width = "100%"><thead>
    <tr align="center">
           <th width="' . $col[0] . '%">D&eacute;partement </th>
           <th width="' . $col[1] . '%">Arrondissement</th>
           <th width="' . $col[2] . '%">Si&egrave;ge</th>
           <th width="' . $col[3] . '%">Structure</th>
           <th width="' . $col[4] . '%">N°</th>
           <th width="' . $col[5] . '%">Noms & Pr&eacute;noms</th>
           <th width="' . $col[6] . '%">Matricule</th>
           <th width="' . $col[7] . '%">Sexe</th>
           <th width="' . $col[8] . '%">Date de naissance</th>
           <th width="' . $col[9] . '%">R&eacute;gion d\'origine</th>
           <th width="' . $col[10] . '%">D&eacute;partement d\'origine</th>
           <th width="' . $col[11] . '%">Statut marital</th>
           <th width="' . $col[12] . '%">Portable</th>
           <th width="' . $col[13] . '%">Dernier Dipl&ocirc;me</th>
           <th width="' . $col[14] . '%">R&eacute;f&eacute;rence Texte<br/> nominatif</th>
           <th width="' . $col[15] . '%">Sit. indemnitaire</th>
           <th width="' . $col[16] . '%">Ind. Solde</th>
           <th width="' . $col[17] . '%">Ind. Carri&egrave;re</th>
           <th width="' . $col[18] . '%">Cat.</th>
           <th width="' . $col[19] . '%">Ech. </th>
           <th width="' . $col[20] . '%">Corps  </th>
           <th width="' . $col[21] . '%">Statut</th>
           <th width="' . $col[22] . '%">date dernier<br/>avancement</th>
           <th width="' . $col[23] . '%"> Sp&eacute;cialit&eacute;<br/>enseign&eacute;e</th>
           <th width="' . $col[24] . '%">DMR/AMR</th>
          </tr></thead><tbody>';

/*foreach ($personnels as $p) {
    $corps .= '<tr><td width ="10%">' . $p['CIVILITE'] . '</td><td>' . $p['NOM'] . ' ' . $p['PRENOM'] . '</td><td>' . $p['LIBELLE']
            . '</td><td>' . $p['PORTABLE'] . '</td></tr>';
}*/
$corps .= "</tbody></table>";
$pdf->setFontSize(10);
//Impression du tableau
$pdf->WriteHTMLCell(0, 5, 10, $y + 15, $corps);

$pdf->Output();