<?php
# Permet d'afficher un formulaire grisee pour les jours feries et fermer

$colonnes = getNbHoraire($classe['GROUPE']);
echo "<input type='hidden' value ='true' name = 'freedays' />";
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
            echo "<tr>";
            if ($i < 10) {
                echo "<td>0" . $i . "</td>";
            } else {
                echo "<td>" . $i . "</td>";
            }
            echo "<td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
            for ($j = 1; $j <= $colonnes; $j++) {
                echo "<td class='freedays'>&nbsp;</td>";
            }

            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>

</table>
<p style="color: #ff0033;margin: 0;padding: 0; text-align: right; margin-top: 5px; margin-right: 10px;">
    Appel impossible &agrave; r&eacute;aliser dans un jour non ouvrable
</p>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableAbsences<?php echo $jour; ?>")) {
            $("#tableAbsences<?php echo $jour; ?>").DataTable({
                "bInfo": false,
                "paging": false,
                "searching": false,
                "scrollY": $(".page").height() - 140

            });
        }
    });
</script>