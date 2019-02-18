<table class="dataTable" id="exclusTable">
    <thead>
        <tr><th>N°</th><th>Noms et Prénoms</th><th>Date Naiss</th><th>P&eacute;riode</th><th>Date exclusion</th><th>Action</th></tr>
    </thead>
    <tbody>
        <?php
        $i = 1;

        foreach ($eleves as $el) {
            $d = new DateFR($el['DATENAISS']);
            echo "<tr><td>$i</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            echo "<td>".$d->getDate()."-".$d->getMois(3)."-".$d->getYear()."</td><td>" . $el['PERIODE'] . "</td>";
           echo "<td>".$el['DATEEXCLUSION']."</td>";
            echo "<td align='center'><img style='cursor:pointer' src='" . img_delete() . "' onclick='supprimerExclus(" . $el['IDELEVE'] . ")' /></td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#exclusTable")) {
            $("#exclusTable").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    {width: "7%"},
                    null,
                    {width: "15%"},
                    {width: "15%"},
                     {width: "15%"},
                    {width: "7%"}
                ]
            });
        }
    });
</script>