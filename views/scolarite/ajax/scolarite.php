<table class="dataTable" id="scolariteTable">
    <thead><th>Date</th><th>Description du frais</th><th>Montant du frais</th><th>Montant pay&eacute;</th><th>Reste</th><th></th></thead>
<tbody>
    <?php
    foreach($scolarites as $scol){
        $d = new DateFR($scol['DATEPAYEMENT']);
        echo "<tr><td>".$d->getJour(3)." ".$d->getDate()."-".$d->getMois(3)."-".$d->getYear()."</td>"
                . "<td>".$scol['DESCRIPTION']."</td><td>".$scol['MONTANTFRAIS']."</td><td>".$scol['MONTANTPAYE']."</td>"
                . "<td>".($scol['MONTANTFRAIS'] - $scol['MONTANTPAYE'])."</td><td>"
                . "<img style = 'cursor:pointer' src = '".img_delete()."' onclick = \"supprimerScolarite('".$scol['IDSCOLARITE']."')\" /></td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("scolariteTable")) {
            $("#scolariteTable").DataTable({
                "bInfo": false,
                "columns": [
                    {"width": "15%"},
                    null,
                    {"width": "15%"},
                    {"width": "13%"},
                    {"width": "8%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>
