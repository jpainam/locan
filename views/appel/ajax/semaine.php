<?php
$colonnes = getNbHoraire($classe['GROUPE']);

echo "<input type='hidden' name ='datedujour' value = '".$datedujour."' />";
echo "<input type='hidden' name='jour' value='".$jour."' />";
?>
<table class="dataTable" cellpadding='0' id="tableAbsences<?php echo $jour; ?>">
    <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th>
            <?php
            for ($j = 1; $j <= $colonnes; $j++) {
                if ($j === 1) {
                    echo "<th>1<sup>&egrave;re</sup>H</th>";
                } elseif ($j !== $colonnes) {
                    echo "<th>" . $j . "<sup>&egrave;me</sup>H</th>";
                } else {
                    echo "<th>" . $j . "<sup>&egrave;me</sup>H</th>";
                }
            }
            ?>
        </tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($eleves as $el) {
            $mat = $el['MATRICULE'];
            echo "<tr>";
            if ($i < 10) {
                echo "<td>0" . $i . "</td>";
            } else {
                echo "<td>" . $i . "</td>";
            }
            echo "<td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            for ($j = 1; $j <= $colonnes; $j++) {
                echo "<td class='centrer'><select name='" . $mat . "_".$j."_". $jour . "' onchange='choisir(this);'>"
                . "<option value=''></option>"
                . "<option value='A'>A</option>"
                . "<option value='R'>R</option>"
                . "<option value='E'>E</option>";
                echo "</select></td>";
            }
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>

</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableAbsences<?php echo $jour; ?>")) {
            $("#tableAbsences<?php echo $jour; ?>").DataTable({
                "bInfo": false,
                "paging": false,
                "searching": false,
                "scrollY": $(".page").height() - 120
                
            });
        }
    });
</script>