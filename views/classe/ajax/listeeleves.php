<?php
if ($deja) {
    echo '<p style ="color: #ff6699;margin: 0; padding: 0; text-align: center">Impossible d\'effectuer une nouvelle saisie. ';
    if (isAuth(407)) {
        echo "Proc&egrave;der a la modification <a href = '" . Router::url("note", "edit", $notation) . "'>ici</a>";
    }
    echo '</p>';
    echo "<input type='hidden' value = 'true' name='deja' />";
}
?>
<table class="dataTable" id="eleveTable">
    <thead><th>Matricule</th><th>Noms & Pr&eacute;noms</th><th>Note</th><th>Absent</th><th>Non not&eacute;</th><th>Observations</th></thead>
<tbody>
    <?php
    if ($deja) {
        foreach ($notes as $note) {
            echo "<tr><td>" . $note['MATRICULE'] . "</td><td>" . $note['NOM'] . " " . $note['PRENOM'] . "</td>";
            if ($note["NOTE"] == 0.00) {
                $note['NOTE'] = "";
            }
            echo "<td align='center'><input type ='text' disabled='disabled' size = '2' value = '" . $note['NOTE'] . "' /></td>";
            if ($note['ABSENT'] === 1) {
                echo "<td align='center'><input type = 'checkbox' disabled='disabled' checked='checked' /></td>";
            } else {
                echo "<td align='center'><input type ='checkbox' disabled='disabled' /></td>";
            }
            if (empty($note['NOTE'])) {
                echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled' /></td>";
            } else {
                echo "<td align='center'><input type='checkbox' disabled='disabled' /></td>";
            }
            echo "<td align='center'><input type='text' value='" . $note['OBSERVATION'] . "' disabled='disabled' size = '30' /></td></tr>";
        }
    } else {
        $i = 1;
        foreach ($eleves as $el) {
            echo "<tr><td>" . $el['MATRICULE'] . "</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            echo "<td align = 'center'><input style=\"text-align: right\" onKeyUp = \"noter('" . $el['IDELEVE'] . "');\" type = 'text' "
            . "name = 'note_" . $el['IDELEVE'] . "' size = '2' tabindex='".$i."'/></td>";
            echo "<td align = 'center'><input type = 'checkbox' name = 'absent_" . $el['IDELEVE'] . "' /></td>";
            echo "<td align = 'center'><input type = 'checkbox' checked='checked' name='nonNote_" . $el['IDELEVE'] . "' /></td>";
            echo "<td align = 'center'><input type = 'text' size = '30' name = 'observation_" . $el['IDELEVE'] . "' /></td></tr>";
            $i++;
        }
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#eleveTable")) {
            $("#eleveTable").DataTable({
<?php
                if($deja){
    echo "scrollY : 500,";
}
?>
                bInfo: false,
                columns: [
                    {"width": "10%"},
                    null,
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "10%"},
                    {"width": "30%"}
                ]
            });
        }
    });
</script>