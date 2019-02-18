<?php
foreach($operations as $op){
    $d = new DateFR($op['DATETRANSACTION']);
    ?>
<div style="max-height: 150px; overflow: auto; left: 829px; top: 112px; display: none;font-size: 11px;" 
     onmouseout="tooltip_off(<?php echo $op['IDCAISSE']; ?>)" onmouseover="tooltip_stop(<?php echo $op['IDCAISSE']; ?>)"
            class="edt_tooltip" id="tooltip<?php echo $op['IDCAISSE'] ?>">
    <span style="width:100%; display:inline-block;"><?php echo  $op['DESCRIPTION']; ?></span><br/>
    <br/><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Enr&eacute;gistr&eacute;e le :</span>
    <span style="width:100px; display:inline-block;"><b><?php echo $d->getDate()." ".$d->getMois(3)." ".$d->getYear(2); ?></b></span>
    
    <br/><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Par :</span>
    <span style="width:100px; display:inline-block;"><?php echo $op['NOMENREG']." ".$op['PRENOMENREG'] ?></span><br/>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Per&ccedil;u le :</span>
    <span style="width:100px; display:inline-block;"><?php 
    $d->setSource($op['DATEPERCEPTION']); 
    echo $d->getDate()." ".$d->getMois(3)." ".$d->getYear(2); ?></span>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Par :</span>
    <span style="width:100px; display:inline-block;"><?php echo $op['NOMPERCU']." ".$op['PRENOMPERCU']; ?></span><br/>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Statut :</span>
    <span style="width:125px; display:inline-block;"><?php if($op['VALIDE'] == 0){
        echo "Op&eacute;ration non valid&eacute;e";
    }else{
        echo "Op&eacute;ration valid&eacute;e";
    }?></span>

</div>
<?php } ?>

<table class="dataTable" id="tableOperation">
    <thead><tr><th>Date</th><th>Ref. Transac.</th><th>Ref. Caisse</th><th>Description</th><th>Montant</th>
            <th>Statut</th><th></th><th></th></tr></thead>
    <tbody>
        <?php
        $d = new DateFR();

        foreach ($operations as $op) {
            $d->setSource($op['DATETRANSACTION']);
            # $type = ($op['TYPE'] == "C" ? "CREDIT" : "DEBIT");
            $type = $op['TYPE'];
            echo "<tr><td>" . $d->getDate() . '-' . $d->getMois(3) . "-" . $d->getYear(2) . "</td>"
            . "<td>" . $op['NIVEAUHTML'].' '.$op['REFTRANSACTION'] . "</td><td>" . $op['REFCAISSE'] . "</td>"
            . '<td>' . $op['DESCRIPTION'] . '</td><td align="right">' . moneyString($op['MONTANT']) . "</td>";
            if ($op['VALIDE'] == 0) {
                echo "<td style='background-color:#ff9999' align='center'>En cours</td>";
            } else {
                echo "<td style='background-color:#99ff99' align='center'>Valid&eacute;e</td>";
            }
            echo "<td align='center'><img onclick = \"tooltip_on(event,'".$op['IDCAISSE']."')\""
                    . " style='cursor:pointer' src='" . img_info() . "' />";
            # Droit d'impression des recu
            if (isAuth(522)) {
                if (!empty($op['PERCUPAR'])) {
                    echo "&nbsp;&nbsp;<img style='cursor:pointer' title='Imprimer le recu de cette operation caisse' "
                    . "src='" . img_print() . "' onclick=\"document.location='" . Router::url("caisse", "recu", $op['IDCAISSE']) . "'\">";
                } else {
                    echo "&nbsp;&nbsp;<img style='cursor:pointer' title='Certifier que vous avez recu ce montant' "
                    . "src='" . img_accept() . "' onclick=\"percuRecu(".$op['IDCAISSE'].")\">";
                }
            }
            echo "</td>";
            if (peutValiderLesOperationsCaisses()) {
                if ($op['VALIDE'] == 0 && !empty($op['PERCUPAR'])) {
                    echo "<td align='center'><img onclick=\"validerOperation(".$op['IDCAISSE'].")\" "
                            . "style='cursor:pointer' src='" . img_valider() . "' /></td>";
                } else {
                    echo "<td align='center'><img style='cursor:pointer' src='" . img_valider_disabled() . "' /></td>";
                }
            } else {
                echo "<td align='center'><img style='cursor:pointer' src='" . img_valider_disabled() . "' /></td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableOperation")) {
            $("#tableOperation").DataTable({
                scrollY : $(".page").height() - 175,
                columns: [
                    {"width": "7%"},
                    null,
                    null,
                    null,
                    {"width": "8%"},
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "3%"}
                ]
            });
        }
    });
</script>