<table class="dataTable" id="responsabletable">
    <thead><tr><th>Date</th><th>El&egrave;ve</th><th>Ref. Caisse</th><th>Description</th><th>Montant</th>
            <th></th><th></th></tr></thead>
    <tbody>
        <?php
        //var_dump($operations);
        $d = new DateFR();
        $montant = 0;
        foreach ($operations as $op) {
            $d->setSource($op['DATETRANSACTION']);

            # $type = ($op['TYPE'] == "C" ? "CREDIT" : "DEBIT");
            $type = $op['TYPE'];
            echo "<tr><td>" . $d->getDate() . '-' . $d->getMois(3) . "-" . $d->getYear(2) . "</td>"
            . "<td>" . $op['NOMEL'] . ' ' . $op['PRENOMEL'] . ".</td><td>" . $op['REFCAISSE'] . "</td>"
            . '<td>' . $op['DESCRIPTION'] . '</td><td align="right">' . moneyString($op['MONTANT']) . "</td>";

            echo "<td align='center'>";
            if(peutSupprimerLesOperationsCaisses()){
                echo "<img style='cursor:pointer' src='".img_delete()."' "
                        . "onclick='supprimerCaisse(".$op['IDCAISSE'].");' />";
            }else{
                echo "<img src='".img_delete_disabled()."' />";
            }
            

            echo "</td><td align='center' title='Observations li&eacute;es &agrave; la suppression'>";
            # Modification car une observation existe deja
            if (!empty($op['OBSERVATIONS'])) {
                echo "<img style='cursor:pointer' src='" . SITE_ROOT . 'public/img/icons/observation.png' . "' "
                . "onclick=\"showObservation(" . $op['IDCAISSE'] . ", 1, 'R')\" />";
            } else {
                if (isAuth(535)) {
                    echo "<img style='cursor:pointer' src='" . SITE_ROOT . 'public/img/icons/observationadd.png' . "' "
                    . "onclick=\"showObservation(" . $op['IDCAISSE'] . ", 2, 'R')\" />";
                } else {
                    echo "<img style='cursor:pointer' src='" . img_valider_disabled() . "' />";
                }
            }
            echo "</td></tr>";
            $montant += intval($op['MONTANT']);
        }
        ?>
        <tr><td></td><td style='font-weight: bold'>TOTAL</td><td></td><td></td>
            <td style="text-align: right"><?php echo moneyString($montant); ?></td>
            <td></td><td></td></tr>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#responsabletable")) {
            $("#responsabletable").DataTable({
                scrollY: $(".page").height() - 175,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "12%"},
                    null,
                    {"width": "8%"},
                    {"width": "5%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>
