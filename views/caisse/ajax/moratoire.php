<table class="dataTable" id="tableEnseignants">
    <thead><tr><th>Date</th><th>El&egrave;ve</th><th>Ref. Moratoire</th><th>Description</th><th>Montant</th>
            <th>Ech&eacute;ance</th><th></th></tr></thead>
    <tbody>
        <?php
        //var_dump($operations);
        $d = new DateFR();
        $montant = 0;
        foreach ($operations as $op) {
            $d->setSource($op['DATEOPERATION']);

            # $type = ($op['TYPE'] == "C" ? "CREDIT" : "DEBIT");
            if($op['ECHEANCE'] < date('Y-m-d', time())){
                echo "<tr style='background-color:#ff9999'>";
            }else{
                echo '<tr>';
            }
            echo "<td>" . $d->getDate() . '-' . $d->getMois(3) . "-" . $d->getYear(2) . "</td>"
            . "<td>" . $op['NOMEL'] . ' ' . $op['PRENOMEL'] . ".</td><td>" . $op['REFMORATOIRE'] . "</td>"
            . '<td>' . $op['DESCRIPTION'] . '</td><td align="right">' . moneyString($op['MONTANT']) . "</td>";
            echo "<td>".date('d-M-y', strtotime($op['ECHEANCE'])).'</td>';
            echo "<td align='center' >";
            if (isAuth(522)) {
                echo "<img style='cursor:pointer' title='Imprimer le recu de ce moratoire' "
                    . "src='" . img_print() . "' onclick=\"document.location='" . Router::url("moratoire", "recu", $op['IDMORATOIRE']) . "'\">";
                
            }
            if(peutSupprimerLesMoratoires() && isAuth(539)){
                echo "&nbsp;|&nbsp;<img style='cursor:pointer' src='" . SITE_ROOT . "public/img/icons/annuler.png' title='Supprimer ce moratoire' "
                        . "onclick='supprimerMoratoire(".$op['IDMORATOIRE'].");' />";
            }else{
                echo "&nbsp;|&nbsp;<img src='".img_delete_disabled()."' />";
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
        if (!$.fn.DataTable.isDataTable("#tableEnseignants")) {
            $("#tableEnseignants").DataTable({
                scrollY: $(".page").height() - 175,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "15%"},
                    null,
                    {"width": "8%"},
                    {"width": "8%"},
                    {"width": "8%"}
                ]
            });
        }
    });
</script>
