<table class="dataTable" id="tableBulletin">
    <thead>
        <tr><th>Classe</th><th>S&eacute;quence</th><th>Date</th><th>Parents &agrave; notifier</th>
            <th>Messages envoy&eacute;s</th><th>Effectu&eacute;e par</th></tr>
    </thead>
    <tbody>
        <?php
        if (!$notifications) {
            $notifications = array();
        }
        $d = new DateFR();
        foreach ($notifications as $not) {
            $d->setSource($not['DATENOTIFICATION']);
            echo "<tr><td>" . $not['NIVEAUHTML'] . "</td><td>" . $not['LIBELLESEQUENCE'] . "</td>"
                    . "<td align='right'>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>"
            . "<td>" . $not['NBREPARENT'] . '</td><td>' . $not['NBREMESSAGE'] . "</td>"
            . "<td>" . $not['NOM'] . ' ' . $not['PRENOM'] . '</td></tr>';
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableBulletin")) {
            $("#tableBulletin").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 100,
                columns: [
                    {"width": "10%"},
                    {"width": "15%"},
                    {"width": "15%"},
                    {"width": "20%"},
                    {"width": "20%"},
                    null
                ]
            });
        }
    });
</script>