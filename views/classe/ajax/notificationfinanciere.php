<div style="text-align: center; margin: 10px;">
    <input style="width: 350px; border: 2px outset buttonface; margin:0" type="button" 
           value="Envoyer un message de rappel aux parents d'&eacute;l&egrave;ves" 
           onclick="envoyerRappel()"/>
</div>
<table class="dataTable" id="tableOperation">
    <thead>
        <tr><th>N°</th><th>Date</th><th>Parents &agrave; notifier</th><th>Messages envoy&eacute;s</th><th>Effectu&eacute;e par</th></tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $d = new DateFR();
        foreach ($notifications as $notif) {
            $d->setSource($notif['DATERAPPEL']);
            echo "<tr><td align='right'>" . $i . "</td><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>"
            . "<td align='right'>" . $notif['NBPARENT'] . "</td><td align='right'>" . $notif['MESSAGEENVOYE'] . "</td>"
            . "<td>" . $notif['NOM'] . " " . $notif['PRENOM'] . "</td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableOperation")) {
            $("#tableOperation").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 200,
                columns: [
                    {"width": "7%"},
                    {"width": "15%"},
                    {"width": "20%"},
                    {"width": "20%"},
                    null
                ]
            });
        }
    });
</script>