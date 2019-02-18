<table class="dataTable" id="tablePersonnel">
    <thead><th>Civ.</th><th>Matricule</th><th>Nom</th><th>Pr&eacute;nom</th><th>Fonction</th><th>Portable</th>
    <th></th></thead>
<tbody>
    <?php
    # 203 consulter les info sur le personnel
    foreach ($personnels as $p) {
        echo "<tr><td>" . $p['CIVILITE'] . "</td><td>" . $p['MATRICULE'] . "</td>";
        echo "<td>" . $p['NOM'] . "</td><td>" . $p['PRENOM'] . "</td><td>" . $p['LIBELLE'] . "</td><td>" . $p['PORTABLE'] . "</td>"
                . "<td align='center'>";
        if(isAuth(203)){
            echo "<img src='".img_print()."' style='cursor:pointer' "
                    . "onclick = \"impression('".$p['IDPERSONNEL']."')\" />&nbsp;&nbsp;";
        }
        if (isAuth(513)) {
            echo "<img style ='cursor:pointer' src = '" . img_edit() . "' "
            . "onclick = \"document.location='" . Router::url("personnel", "edit", $p['IDPERSONNEL']) . "'\" />&nbsp;&nbsp;";
        } else {
            echo "<img style ='cursor:pointer' src = '" . img_edit_disabled() . "' />&nbsp;&nbsp;";
        }
        if (isAuth(507)) {
            echo "<img style ='cursor:pointer' src = '" . img_delete() . "' "
                    . "onclick =\"deleteRow('" . Router::url("personnel", "delete", $p['IDPERSONNEL']) . "', '".$p['NOM']." ".$p['PRENOM']."')\" />";
        } else {
            echo "<img style ='cursor:pointer' src = '" . img_delete_disabled() . "' />";
        }
        echo "</td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tablePersonnel")) {
            $('#tablePersonnel').DataTable({
                "columnDefs": [
                    {"width": "4%", "targets": 0},
                    {"width": "10%", "targets": 1},
                    {"width": "15%", "targets": 4},
                    {"width": "15%", "targets": 5},
                    {"width": "10%", "targets": 6}
                ]
            });
        }
    });
</script>