<table id="tableEmplois" class='dataTable'>
    <thead><th>Jour</th><th>Horaire</th><th>D&eacute;but</th><th>Fin</th><th>Enseignant</th><th>Mati&egrave;re</th><th></th></thead>
<tbody>
    <?php
    foreach ($enseignements as $ens) {
        echo "<tr><td>" . getJourSemaine($ens['JOUR']) . "</td><td>".$ens['DESCRIPTIONHTML']."</td>"
                . "<td>" . substr($ens['HEUREDEBUT'], 0, 5) . "</td><td>" . substr($ens['HEUREFIN'], 0, 5) . "</td>"
        . "<td>" . $ens['NOM'] . " " . $ens['PRENOM'] . "</td><td>" . $ens['LIBELLE'] . "</td><td align = 'center'>"
        . "<img style = 'cursor:pointer' onclick = \"supprimerHoraire('" . $ens['IDEMPLOIS'] . "')\" src = '" . SITE_ROOT . "public/img/delete.png' /></td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableEmplois")) {
            $("#tableEmplois").DataTable({
                "bInfo": false,
                paging: false,
                scrollY: $(".page").height() - 150,
                "columns": [
                    {"width": "10%"},
                    {"width": "10%"},
                    {"width": "7%"},
                    {"width": "7%"},
                    null,
                    null,
                    {"width": "5%"}
                ]
            });
        }
    });
</script>
