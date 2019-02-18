<?php foreach ($messages as $m) { ?>
    <div style="max-height: 150px; overflow: auto; left: 829px; top: 150px; display: none;font-size: 11px" 
         onmouseout="tooltip_off(<?php echo $m['IDMESSAGEENVOYE']; ?>)" 
         onmouseover="tooltip_stop(<?php echo $m['IDMESSAGEENVOYE']; ?>)"
         class="edt_tooltip" id="tooltip<?php echo $m['IDMESSAGEENVOYE'] ?>">
        <p style="font-weight: bold; margin:0; padding:0">Contenu du message envoy&eacute;</p>
        <br>
        <span style="display:inline-block; width: 100px"><?php echo $m['MESSAGE']; ?></span>
    </div>
    <?php
}
?>
<table class="dataTable" id="tableMessage">
    <thead><tr><th>Date d'envoi</th><th>Destinataires</th><th>Exp&eacute;diteurs</th>
            <th></th>
        </tr></thead>
    <tbody>
        <?php
# 325 : Droit pour suppression des messages envoyes
        $d = new DateFR();
        foreach ($messages as $m) {
            $d->setSource($m['DATEENVOIE']);
            echo "<tr><td>" . $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " &agrave " .
            $d->getTime() . "</td><td>" . $m['DESTINATAIRE'] . "</td><td>" . $m['NOM'] . " " . $m['PRENOM'] . "</td>"
            . "<td align='center'><img style='cursor:pointer' src='" . img_info() . "' "
            . " onclick = \"tooltip_on(event,'" . $m['IDMESSAGEENVOYE'] . "')\" />&nbsp;&nbsp;";
            if (isAuth(325)) {
                echo "<img style='cursor:pointer' src='" . img_delete() . "' "
                        . "onclick=\"supprimerMessageEnvoye(".$m['IDMESSAGEENVOYE'].")\" />";
            } else {
                echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableMessage")) {
            $("#tableMessage").DataTable({
                bInfo: false
            });
        }
    });
</script>