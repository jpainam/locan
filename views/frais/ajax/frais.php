<table class="dataTable" id="fraisTable">
    <thead><tr><th>Description du frais scolaire</th><th>Montant</th><th>Ech&eacute;ances</th><th></th></tr></thead>
    <tbody>
        <?php 
        $montanttotal = 0;
        foreach ($frais as $f) {
            $montanttotal += $f['MONTANT'];
            $d = new DateFR($f['ECHEANCES']);
            $echeance = $d->getJour(3) . " " . $d->getDate() . "-" . $d->getMois() . "-" . $d->getYear();
            echo "<tr><td>" . $f['DESCRIPTION'] . "</td><td align='right'>" . moneyString($f['MONTANT']) . "</td><td>" . $echeance . "</td>"
            . "<td align = 'center'>";
            if (isAuth(510)) {
                echo "<img style = 'cursor:pointer' src = \"" . SITE_ROOT . "public/img/delete.png\" "
                . "onclick = \"supprimerFrais('" . $f['IDFRAIS'] . "')\" />&nbsp;&nbsp;";
            }
            if (isAuth(511)) {
                echo "<img id = 'img-edit' style = 'cursor:pointer' src = '" . img_edit() . "'  "
                . "onclick = \"openEditForm('" . $f['IDFRAIS'] . "')\" />";
                # Ajout des input hidden pour la modification
                echo "<input type='hidden' name='description" .$f['IDFRAIS']."' value='".$f['DESCRIPTION']."' />";
                echo "<input type='hidden' name='montant" . $f['IDFRAIS']."' value ='".$f['MONTANT']."' />";
                echo "<input type='hidden' name='echeances" . $f['IDFRAIS']."' value='".$f['ECHEANCES']."' />";
            }
            echo "</td></tr>";
        }
        echo "<tr><td>TOTAL</td><td align='right'>".  moneyString($montanttotal)."</td><td><td></tr>";
        ?>
    </tbody>
</table>

<script>
    if (!$.fn.DataTable.isDataTable("#fraisTable")) {
        $("#fraisTable").DataTable({
            "bInfo": false,
            "scrollY": $(".page").height() - 100,
            "searching": false,
            "paging": false,
            "columns": [
                null,
                {"width": "15%"},
                {"width": "20%"},
                {"width": "10%"}
            ]
        });
    }
</script>
