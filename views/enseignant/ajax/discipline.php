<table class="dataTable" id="tableDiscipline">
    <thead><tr><th>N°</th><th>Noms et Pr&eacute;noms</th><th>Retards</th><th>Absences</th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($absences as $abs) {
            echo "<tr><td>" . $i . "</td><td>" . $abs['NOM'] . " " . $abs['PRENOM'] . "</td>"
            . "<td align='right'>" . $abs['SUMRETARD'] . "</td>"
                    . "<td align='right'>" . $abs['SUMABSENCE'] . " Hrs</td>"
                    . "<td align='center'><img src='".img_print()."' style='cursor:pointer' "
                    . "onclick=\"imprimerAbsence(".$abs['IDPERSONNEL'].")\" /></td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableDiscipline")) {
            $("#tableDiscipline").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>