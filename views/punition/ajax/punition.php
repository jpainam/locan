<table class="dataTable" id="punitionTable">
    <thead><th>Date</th><th>El&egrave;ves</th><th>Puni par</th><th>Type</th><th>Motif</th><th>Dur&eacute;e</th><th></th></thead>
<tbody>
    <?php
    foreach ($punitions as $p) {
        $d = new DateFR($p['DATEPUNITION']);
        echo "<tr><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td><td>" . $p['NOM'] . " " . $p['PRENOM'] . "</td>";
        echo "<td>" . $p['PUNISSEUR'] . "</td><td>" . $p['LIBELLE'] . "</td><td>" . $p['MOTIF'] . "</td><td>" . $p['DUREE'] . " jrs</td>";
        //echo "<td><img style ='cursor:pointer' src = '" . img_edit() . "' />&nbsp;&nbsp;";
        echo "<td><img style ='cursor:pointer' src = '" . img_delete() . "' onclick=\"supprimerPunition('".$p['IDPUNITION']."')\" />&nbsp;&nbsp;";
        echo "<img style ='cursor:pointer' src = '" . img_print() . "' onclick = \"printPunition('".$p['IDPUNITION']."')\" /></td></tr>";
    }
    ?>
</tbody>
</table>