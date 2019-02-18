<style>
    .listeAppel{
        border-collapse: collapse;
        margin: auto;
    }
    .listeAppel th, td{
        border: 1px solid #000;
    }
    .listeAppel .foncee{
        border-right: 5px solid #000;
    }
</style>
<?php
# Nombre de colonnes, pour les 1eres et Tle, 9 colonnes
$l = 9;
if ($classe['GROUPE'] !== 0 && $classe['GROUPE'] !== 1) {
    $l = 8;
}
?>
<table class="listeAppel">
    <thead><tr><th>N°</th><th colspan="2">Noms & Pr&eacute;noms</th><th class='foncee' colspan="<?php echo $l; ?>">Lundi</th>
            <th class='foncee' colspan="<?php echo $l; ?>">Mardi</th>
            <th class='foncee' colspan="<?php echo $l; ?>">Mercredi</th><th class='foncee' colspan="<?php echo $l; ?>">Jeudi</th>
            <th  class='foncee' colspan="<?php echo $l; ?>">Vendredi</th><th>Total</th></tr></thead>
    <tbody>
        <tr><td colspan="3" align='center'><b>HEURES</b></td>
            <?php
            for ($i = 1; $i <= $l * 5; $i++) {
                if ($i % $l == 0) {
                    echo "<td class='foncee'>&nbsp;&nbsp;</td>";
                } else {
                    echo "<td>&nbsp;&nbsp;</td>";
                }
            }
            ?>
            <td></td>
        </tr>
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
            echo "<td>" . $el['SEXE'] . "</td>";
            for ($j = 1; $j <= $l * 5; $j++) {
                if ($j % $l == 0) {
                    echo "<td class='foncee'></td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "<td></td>";
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>
</table>