<?php
if ($deja) {
    echo '<input type="hidden" value="true" name="deja" />';
    echo '<p style ="color: #ff6699;margin: 0; padding: 0; text-align: center">Effectuer une modification de saisie</p>';
}
?>

<table class="dataTable" id="tablePeriodique">
    <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th><th>T.Abs</th><th>Abs.J</th><th>Cons</th><th>D&eacute;cis°</th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($eleves as $el) {
            $abs = $just = $cons = $decis = "";
            if ($deja) {
                $absence = getAbsenceElevePeriodique($el['IDELEVE'], $absences);
                if (!is_null($absence)) {
                    $abs = $absence['ABSENCE'];
                    $just = $absence['JUSTIFIER'];
                    $cons = $absence['CONSIGNE'];
                    $decis = $absence['DECISION'];
                }
            }
            echo "<tr  style='text-align:center'><td>" . $i . "</td><td style='text-align:left'>" . $el['NOM'] . ' ' . $el['PRENOM'] . "</td>"
            . "<td><input type='text' size='5' name='tab_" . $el['IDELEVE'] . "' value='" . ($abs == 0 ? "" : $abs) . "' /></td>"
            . "<td><input type='text' size='5' name='abj_" . $el['IDELEVE'] . "' value='" . ($just == 0 ? "" : $just) . "'/></td>"
            . "<td><input type='text' size='5' name='cons_" . $el['IDELEVE'] . "' value='" . ($cons == 0 ? "" : $cons) . "' /></td>"
            . "<td><input type='text' size='5' name='decis_" . $el['IDELEVE'] . "' value='" . ($decis == 0 ? "" : $decis) . "' /></td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<input type="hidden" name="idclasse" value="<?php echo $idclasse; ?>" />
<input type="hidden" name="idperiode" value="<?php echo $idperiode; ?>" />
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tablePeriodique")) {
            $("#tablePeriodique").DataTable({
                <?php
                if ($deja) {
                    echo "scrollY: 500,";
                }
                ?>
                columns: [
                    {width: "5%"},
                    null,
                    {width: "10%"},
                    {width: "10%"},
                    {width: "10%"},
                    {width: "10%"}
                ]
            });
        }
    });
</script>
<?php

function getAbsenceElevePeriodique($ideleve, $absences) {
    foreach ($absences as $abs) {
        if ($abs['ELEVE'] === $ideleve) {
            return $abs;
        }
    }
    return null;
}
