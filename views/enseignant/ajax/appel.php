<?php foreach ($absences as $abs) { ?>
    <div style="max-height: 250px; height: 100px; overflow: auto; left: 829px; top: 112px; display: none;font-size: 11px" 
         onmouseout="tooltip_off(<?php echo $abs['IDABSENCEENSEIGNANT']; ?>)" onmouseover="tooltip_stop(<?php echo $abs['IDABSENCEENSEIGNANT']; ?>)"
         class="edt_tooltip" id="tooltip<?php echo $abs['IDABSENCEENSEIGNANT'] ?>" >
        <p style="font-weight: bold"><?php echo $abs['CODE'] . " - " . $abs['NIVEAUHTML']; ?></p>
        <span style="width:45px; display:inline-block; font-weight:normal; text-decoration:underline;">Autres :</span>
        <span style="width:200px; display:inline-block;"><b><?php echo $abs['OBSERVATION']; ?></b></span>
    </div>
    <?php
}
?>
<table class="dataTable" id="appelEnseignant">
    <thead><tr><th>Dates</th><th>Noms & Pr&eacute;noms</th>
            <th>Mati&egrave;res</th><th>Classes</th><th>Retard</th><th>Absence</th><th></th></tr></thead>
    <tbody>
        <?php
        $d = new DateFR();
        $i = 0;
        foreach ($absences as $abs) {

            $d->setSource($abs['DATEJOUR']);
            echo "<tr><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear(2) . "</td>";
            echo "<td>" . substr($abs['NOM'] . " " . $abs['PRENOM'], 0, 20) . "</td>"
            . "<td>" . $abs['CODE'] . "</td><td>" . $abs['NIVEAUHTML'] . "</td>";
            if ($abs['ETAT'] == "R") {
                echo "<td class='retard' align='center'>" . substr($abs['RETARD'], 0, 5) . "</td>";
            } else {
                echo "<td></td>";
            }
            if ($abs['ETAT'] == "A") {
                echo "<td class='absent' align='center'>" . $abs['NBHEURE'] . "H</td>";
            } else {
                echo "<td></td>";
            }
            echo "<td align='center'><img style='cursor:pointer' src='" . img_info() . "' "
            . "onclick = \"tooltip_on(event,'" . $abs['IDABSENCEENSEIGNANT'] . "')\"/>";
            if (isAuth(327)) {
                echo "&nbsp;&nbsp;<img class='img_delete' src='" . img_delete() . "' "
                        . "onclick=\"supprimerAbsence(".$abs['IDABSENCEENSEIGNANT'].")\" style='cursor:pointer' />";
            } else {
                echo "&nbsp;&nbsp;<img src='" . img_delete_disabled() . "' style='cursor:pointer' />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#appelEnseignant")) {
            $("#appelEnseignant").DataTable({
                bInfo: false,
                paging: false,
                searching: false,
                columns: [
                    {"width": "10%"},
                    null,
                    {"width": "10%"},
                    {"width": "10%"},
                    {"width": "10%"},
                    {"width": "10%"},
                    {"width": "7%"}
                ]
            });
        }

        //Popup form
        $("#delete-dialog-form").dialog({
            autoOpen: false,
            height: 180,
            width: 350,
            modal: true,
            resizable: false,
            buttons: {
                Supprimer: function () {
                    supprimerAbsence();
                    $(this).dialog("close");
                },
                Annuler: function () {
                    $(this).dialog("close");
                }
            }
        });
        $(".img_delete").on("click", function () {
            var horaires = "";
            var inputs = $(this).parent().prev().children("input");
            inputs.each(function () {
                var str = $(this).val().split("_");
                horaires += "<option value='" + str[0] + "'>" + str[1] + "</option>";
            });
            $("select[name=supprimerHoraire]").html(horaires);
            $("#delete-dialog-form").dialog("open");
        });

    });

</script>