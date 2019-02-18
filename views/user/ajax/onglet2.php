<script>
    $(document).ready(function () {
        $("#dataTable2").DataTable({
            "columns": [
                {"width": "5%"},
                null,
                {"width": "5%"}
            ],
            "bInfo": false
        });
    });
</script>
<table class="dataTable" id="dataTable2">
    <thead><tr><th>CODE</th><th>LIBELLE</th><th>ACTIF</th></tr></thead>
    <tbody>
        <?php
        $mesdroits = is_null($mesdroits) ? array() : $mesdroits;
        foreach ($droits as $droit) {
            echo "<tr><td>" . $droit['CODEDROIT'] . "</td><td>" . $droit['LIBELLE'] . "</td><td align = 'center'>";
            if (in_array($droit['CODEDROIT'], $mesdroits)) {
                echo "<input type = 'checkbox' name = 'droits[]' checked value = '" . $droit['CODEDROIT'] . "' />";
            } else {
                echo "<input type = 'checkbox' name = 'droits[]' value = '" . $droit['CODEDROIT'] . "' />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>