<table class="dataTable" id="tab_ra">
    <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
    <tbody><tr><td>
                <?php
                echo $admin['MATRICULE'] . "</td><td>" . $admin['NOM'] ." " . $admin['PRENOM'] . "</td>
               <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                . " onclick = \"deletePrincipale(3);\"  />";
                ?>
            </td></tr></tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tab_ra")) {
        $("#tab_ra").DataTable({
            "paging": false,
            "bInfo": false,
            "scrollY": 100,
            "searching": false,
             "scrollCollapse": true,
            "columns": [
                {"width": "20%"},
                null,
                {"width": "5%"}
            ]
        });
    }
</script>