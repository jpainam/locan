<table class="dataTable" id="tab_mat">
    <thead><tr><th>Ordre</th><th>Matière</th><th>Enseignants</th><th>Groupe</th><th>Coefficient</th></tr></thead>
    <tbody>
        <?php
        foreach ($enseignements as $ens) {
            echo "<tr><td>" . $ens['ORDRE'] . "</td><td>"
            . "<input type='hidden' value='" . $ens['IDMATIERE'] . "'/>" . $ens['CODE'] . " - " . $ens['MATIERELIBELLE'] . "</td><td>" . $ens['NOM'] . " " . $ens['PRENOM'] . "</td>"
                    . "<td><input type='hidden' value='".$ens['GROUPE']."' />" . $ens['DESCRIPTION'] . "</td>"
            . "<td>" . $ens['COEFF'] . "</td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    if (!$.fn.DataTable.isDataTable("#tab_mat")) {
        $('#tab_mat').DataTable({
            "paging": false,
            "bInfo": false,
            "scrollY": 300,
            "columns": [
                {"width": "5%"},
                null,
                null,
                null,
                {"width": "5%"}
            ]
        });
    }
</script>
