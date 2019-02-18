<div style="text-align: center; color: #ff6666"><blink>
    <?php if(!empty($info)){
        echo $info;
    } ?>
    </blink></div>
<table class="dataTable" id="sauvegardeTable">
    <thead><tr><th>N°</th><th>Description</th><th>Taille</th><th></th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        $d = new DateFR();
        if (!empty($sauvegardes)) {
            foreach ($sauvegardes as $save) {
                $d->setSource($save['DATESAUVEGARDE']);
                echo "<tr><td style='text-align:center'>" . $i . "</td><td>Sauvegarde des données " . $save['DESCRIPTION'] . " : "
                . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " &agrave; " . $d->getTime() . "</td>"
                . "<td style='text-align:right'>" . substr(moneyString($save['TAILLE']), 0, -3) . "KB</td>"
                . "<td style='text-align:center'>"
                . "<img  title='Telecharger cette sauvegarde' style='cursor:pointer' "
                . "onclick='telechargerSauvegarde(" . $save['IDSAUVEGARDE'] . ")' src='" . img_download() . "' />"
                . "&nbsp;&nbsp;&nbsp;<img title='Restaurer cette sauvegarde' src='" . img_restaure() . "' style='cursor:pointer' "
                . "onclick='restaurerSauvegarde(" . $save['IDSAUVEGARDE'] . ")' /></td>"
                . "<td style='text-align:center'><img style='cursor:pointer' onclick='supprimerSauvegarde(" . $save['IDSAUVEGARDE'] . ")' src='" . img_delete() . "'>"
                . "</td></tr>";
                $i++;
            }
        }
        ?>
    </tbody>
</table>
<div style="margin: 10px;text-align: center">
    <input style="width: 350px; border: 2px outset buttonface; margin:0" type="button" 
           value="Effectuer une nouvelle sauvegarde" onclick="nouvelleSauvegarde()"/>
</div>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#sauvegardeTable")) {
            $("#sauvegardeTable").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 150,
                columns: [
                     {"width": "5%"},
                null,
                {"width": "10%"},
                {"width": "7%"},
                {"width": "5%"}
                ]
            });
        }
    });
</script>