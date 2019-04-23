<table id="tableManuel" class='dataTable'>
    <thead><th>Titre du manuel</th><th>Editeurs</th><th>Auteurs</th><th>Prix</th>
    <th>Action</th></thead>
<tbody>
    <?php
    if (isset($manuels) && !empty($manuels)) {
        foreach ($manuels as $m) {
            echo "<tr><td>" . $m['TITRE'] . "</td><td>" . $m['EDITEURS'] . "</td><td>"
            . $m['AUTEURS'] . "</td><td align='right'>" . $m['PRIX'] . "</td>"
            . "<td align='right'><img style='cursor:pointer' src='" . img_edit() . "' "
            . "onclick=\"openEditForm(" . $m['IDMANUELSCOLAIRE'] .")\" />";
            if (isAuth(244)) {
                echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete() . "' "
                . "onclick='supprimerManuel(" . $m['IDMANUELSCOLAIRE'] . ", \"". $m['TITRE']."\")' />";
            } else {
                echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
            }
            echo "</td></tr>";
        }
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableManuel")) {
            $("#tableManuel").DataTable({
                bInfo: false,
                paging: false,
                columns: [
                    null,
                    null,
                    null,
                    {"width": "13%"},
                    {"width": "7%"}
                ]
            });
        }
    });
</script>