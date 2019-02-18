<table class="dataTable" id="justificationTable">
    <thead><tr><th>N°</th><th>Nom & Pr&eacute;nom</th><th>Horaires</th><th>Etat</th><th>Justifier?</th><th></th></tr></thead>
    <tbody><?php
        $horaire = getNbHoraire($classe['GROUPE']);
        $i = 1;
        foreach ($eleves as $el) {
            for ($j = 1; $j <= $horaire; $j++) {
                $abs = estAbsent($el['IDELEVE'], $absences, $j);
                if (!is_null($abs)) {
                    echo "<tr>";
                    if ($i < 10) {
                        echo "<td>0" . $i . "</td>";
                    } else {
                        echo "<td>" . $i . "</td>";
                    }

                    echo "<td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
                    if ($abs['HORAIRE'] == 1) {
                        echo "<td style='text-align:center'>" . $abs['HORAIRE'] . "<sup>&egrave;re</sup>Heure</td>";
                    } else {
                        echo "<td style='text-align:center'>" . $abs['HORAIRE'] . "<sup>&egrave;me</sup>Heure</td>";
                    }
                    $class = "";
                    if (!empty($abs['JUSTIFIER'])) {
                        $class = "justifier";
                    } elseif ($abs['ETAT'] === "A") {
                        $class = "absent";
                    } elseif ($abs['ETAT'] === "R") {
                        $class = "retard";
                    } elseif ($abs['ETAT'] === "E") {
                        $class = "exclu";
                    }
                    echo "<td class='$class'></td>";
                    if (!empty($abs['JUSTIFIER'])) {
                        echo "<td align='center'><input type='checkbox' checked disabled /></td>";
                    } else {
                        echo "<td align='center'><input type='checkbox' disabled /></td>";
                    }
                    echo "<td align='center'>";
                    if (!empty($abs['JUSTIFIER'])) {
                        echo "<img style='cursor:pointer' src = '" . img_valider_disabled() . "' />&nbsp;&nbsp;&nbsp;";
                        echo "<img style='cursor:pointer' src = '" . img_delete() . "' "
                        . "onclick = \"supprimerJustification('" . $abs['JUSTIFIER'] . "', '" . $abs['IDABSENCE'] . "')\" />&nbsp;&nbsp;";
                        echo "<img style='cursor:pointer' src='".img_print()."' "
                                . "onclick=\"printJustification('".$abs['JUSTIFIER']."', '".$abs['IDABSENCE']."')\" />";
                    }else{
                        echo "<img style='cursor:pointer' src = '" . img_valider() . "' 
                            onclick = \"openFormJustification(this, '" . $abs['IDABSENCE'] . "');\"  />&nbsp;&nbsp;&nbsp;";
                        echo "<img style='cursor:pointer' src = '" . img_delete_disabled() . "' />&nbsp;&nbsp;";
                        echo "<img style='cursor:pointer' src='".img_print()."' />";
                    }
                    echo "</td></tr>";

                    $i++;
                }
            }
        }
        ?></tbody>
</table>
<div id="justification-dialog-form" class="dialog" title="Justification" >
    <span style="width: 100%"><label>Motif de la justification : </label><input style="width: 100%" type="text" name="motif" /></span>
    <span style="width: 100%"><label>Description d&eacute;taill&eacute; : </label>
        <textarea name="description" rows="3" cols="40" ></textarea></span>
</div>
<script>
    $(document).ready(function () {
        $("#justificationTable").DataTable({
            "bInfo": false,
            "paging": false,
            "searching": false,
            "scrollY": $(".page").height() - 110,
            "columns": [
                {"width": "5%"},
                null,
                {"width": "10%"},
                {"width": "7%"},
                {"width": "7%"},
                {"width": "10%"}

            ]
        });
        $("#justification-dialog-form").dialog({
            autoOpen: false,
            height: 270,
            width: 370,
            modal: true,
            resizable: false,
            buttons: {
                "Ajouter": function () {
                    justifier();
                    $(this).dialog("close");
                },
                Annuler: function () {
                    $(this).dialog("close");
                }
            }
        });
    });
</script>