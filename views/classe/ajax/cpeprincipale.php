<table class="dataTable" id="tab_cpe">
    <thead><tr><th>Civilit&eacute;</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
    <tbody><tr><td>
                <?php
                echo $cpe['CIVILITE'] . "</td><td>" . $cpe['NOM'] . " " . $cpe['PRENOM'] . "</td>
               <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                . " onclick = \"deletePrincipale(2);\"  />";
                ?>
            </td></tr></tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tab_cpe")) {
        $("#tab_cpe").DataTable({
            "paging": false,
            "bInfo": false,
            "scrollY": 200,
            "scrollCollapse": true,
            "searching": false,
            "columns": [
                {"width": "20%"},
                null,
                {"width": "5%"}
            ]
        });
    }
</script>