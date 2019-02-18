<table class="dataTable" id="tableNotes">
    <thead><th>Matricule</th><th>Noms & Pr&eacute;noms</th>
                    <th>CC</th><th>DP</th><th>SI</th>
                    <th>Non not&eacute;</th><th>Observations</th>
</thead>
<tbody>
    <?php
        foreach ($eleves as $el) {
            echo "<tr><td>" . $el['MATRICULE'] . "</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            echo "<td align = 'center'><input style=\"text-align: right\"  type = 'text' name = 'cc_" . $el['IDELEVE'] . "' size = '2' /></td>";
            echo "<td align = 'center'><input style=\"text-align: right\"  type = 'text' name = 'dp_" . $el['IDELEVE'] . "' size = '2' /></td>";
            echo "<td align = 'center'><input style=\"text-align: right\"  type = 'text' name = 'si_" . $el['IDELEVE'] . "' size = '2' /></td>";
            //echo "<td align = 'center'><input type = 'checkbox' name = 'absent_" . $el['IDELEVE'] . "' /></td>";
            echo "<td align = 'center'><input type = 'checkbox' checked='checked' name='nonNoteCC_" . $el['IDELEVE'] . "' /></td>";
            echo "<td align = 'center'><input type = 'text' size = '30' name = 'observationCC_" . $el['IDELEVE'] . "' /></td></tr>";
        }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        $('#tableNotes input[type="text"]').keydown(function (e) {
            if (e.keyCode === 40) {
                //$(this).next('input[type=text]').focus();
                var td = $(this).parent();
                var tr = td.parent();
                tr = tr.next();
                td = tr.children("td")[2];
                //console.log(td);
                var input = $(td).children("input");
                console.log(input);
                input.focus();
            } else if (e.keyCode === 38) {
                //$(this).prev('input[type=text]').focus();
                var td = $(this).parent();
                var tr = td.parent();
                tr = tr.prev();
                td = tr.children("td")[2];
                //console.log(td);
                var input = $(td).children("input");
                console.log(input);
                input.focus();
            }
        });
        if (!$.fn.DataTable.isDataTable("#tableNotes")) {
            $("#tableNotes").DataTable({
<?php
if ($deja) {
    echo "scrollY : 500,";
}
?>
                columns: [
                    {"width": "10%"},
                    null,
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "10%"},
                    {"width": "20%"}
                ]
            });
        }
    });
</script>