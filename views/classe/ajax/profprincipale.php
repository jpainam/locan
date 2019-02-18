<table class="dataTable" id="tab_pp">
    <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
    <tbody><tr><td>
                <?php
                echo $prof['MATRICULE'] . "</td><td>" . $prof['CNOM'] . "</td>
               <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                . " onclick = \"deletePrincipale(1);\"  />";
                ?>
            </td></tr></tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tab_pp")) {
        $("#tab_pp").DataTable({
            "paging": false,
            "bInfo": false,
            "scrollY": 100,
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