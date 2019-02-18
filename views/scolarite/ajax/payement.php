
<table class="dataTable" id="payementTable">
    <thead><tr><th>N°</th><th>El&egrave;ves</th><th>Date</th>
            <th>Pay&eacute; ? </th><th>R&eacute;alis&eacute; par</th>
            <th></th></tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $d = new DateFR();
        foreach ($eleves as $el) {
            echo "<tr><td>" . $i . "</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            if (empty($el['IDSCOLARITE'])) {
                echo "<td></td><td align='center'><input type='checkbox' disabled /></td>";
                echo "<td></td><td align='center'>";
                if (isAuth(508)) {
                    echo "<img style='cursor:pointer' title='Effectuer le payement' "
                    . "src='" . img_valider() . "' onclick=\"payer('" . $el['IDELEVE'] . "')\" />&nbsp;&nbsp; ";
                } else {
                    echo "<img style='cursor:pointer' title='Vous ne disposez pas du droit de payement' "
                    . "src = '" . img_valider_disabled() . "' />&nbsp;&nbsp;";
                }
                echo "<img style='cursor:pointer' title='Supprimer le payement' "
                . "src='" . img_delete_disabled() . "' /></td>";
            } else {
                $d->setSource($el['DATEPAYEMENT']);
                echo "<td>" . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " "
                . $d->getYear() . "</td><td align='center'><input type='checkbox' checked disabled /></td>";
                echo "<td>" . $el['NOMREALISATEUR'] . ' ' . $el['PRENOMREALISATEUR'] . "</td>";
                echo "<td align='center'><img style='cursor:pointer' title='Effectuer le payement' "
                . "src='" . img_valider_disabled() . "' />&nbsp;&nbsp;";
                if (isAuth(519)) {
                    echo "<img style='cursor:pointer' title='Supprimer le payement' "
                    . "onclick=\"depayer('" . $el['IDSCOLARITE'] . "')\" src='" . img_delete() . "' /></td>";
                } else {
                    echo "<img style='cursor:pointer' title=\"Vous ne disposez pas du droit de suppression\" 
                        src='" . img_delete_disabled() . "' /></td>";
                }
            }
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#payementTable")) {
            $("#payementTable").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "15%"},
                    {"width": "10%"},
                    null,
                    {"width": "7%"}
                ]
            });
        }
    });
</script>