<table class="dataTable" id="responsabletable">
    <thead><tr><th>Civilit&eacute;</th><th>Nom & Pr&eacute;nom</th><th></th></thead>
    <tbody>
        <?php
        foreach ($responsables as $resp) {
            echo "<tr><td>" . $resp['CIVILITE'] . "</td><td>" . $resp['NOM'] . " " . $resp['PRENOM'] . "</td>
               <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
            . " onclick = \"deleteResponsabilite('" . $resp['IDRESPONSABLEELEVE'] . "');\"  /></td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#responsabletable")) {
        $("#responsabletable").DataTable({
            "paging": false,
            "bInfo": false,
            "scrollCollapse": true,
            "scrollY": 300,
            "searching": false,
            "columns": [
                {"width": "5%"},
                null,
                {"width": "5%"}
            ]
        });
    }
</script>