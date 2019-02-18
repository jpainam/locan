<style>
    .tableAbsences{
        border-collapse: collapse;
        border: 1px solid #000;
        margin: auto;
    }
    .tableAbsences td, th{
        border:1px solid #000;
        text-align: center;
    }
    .tableAbsences tbody tr:nth-child(2n){
        background-color: rgb(225, 196, 196); //#E1C4C4
    }
    .tableAbsences tbody tr:nth-child(2n +1){
        background-color: #FFF;
    }
    .tableAbsences tbody tr:hover{
        background-color: rgb(207,160,160);
    }
    .tableAbsences .foncee{
        border-right: 8px solid #000;
    }
    .tableAbsences tr td:first-child{
        text-align: left !important;
    }
</style>
<table class="tableAbsences">
    <thead><tr><th rowspan="2">Noms & Pr&eacute;noms</th>
            <?php
            $i = 1;
            $class = "";

            foreach ($horaires as $h) {
                if ($i != count($horaires)) {
                    $class = "foncee";
                } else {
                    $class = "";
                }
                if ($h === 1) {
                    echo "<th colspan='4' class='" . $class . "'>1<sup>&egrave;re</sup> Heure</th>";
                } elseif ($h === 2) {
                    echo "<th colspan='4' class='" . $class . "'>2<sup>nde</sup> Heure</th>";
                } else {
                    echo "<th colspan='4' class='" . $class . "'>" . $h . "<sup>&egrave;me</sup> Heure</th>";
                }
                $i++;
            }
            ?>
        </tr>
        <tr>
            <?php
            $legendes = ["P", "A", "R", "E"];
            $i = 1;
            for ($j = 0; $j < count($horaires) * 4; $j++) {
                if ($i % 4 == 0 && $i != count($horaires) * 4) {
                    $class = "foncee";
                } else {
                    $class = "";
                }
                echo "<th class = '" . $class . "'>" . $legendes[$j % 4] . "</th>";
                $i++;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $str = "";
        foreach ($eleves as $el) {
            $i = 1;
            $mat = $el['MATRICULE'];
           
            ?>
            <tr><td><?php echo $el['NOM'] . " " . $el['PRENOM']; ?></td>
                <?php foreach ($horaires as $h) { 
                     $str .= "#R_heure_" . $mat."_".$h . ", #E_heure_" . $mat ."_".$h. ",";
                    ?>
                    <td><input onchange ="appel('<?php echo $mat."_".$h; ?>')" name="<?php echo $el['MATRICULE']."_".$h; ?>" type="radio" 
                               value = '<?php echo "P_" . $mat."_".$h; ?>' checked /></td>
                    <td><input onchange ="appel('<?php echo $mat."_".$h; ?>')" name="<?php echo $el['MATRICULE']."_".$h; ?>" type="radio" 
                               value = '<?php echo "A_" . $mat."_".$h; ?>' /></td>
                    <td><input name="<?php echo $mat."_".$h; ?>" type="radio" value = '<?php echo "R_" . $mat."_".$h; ?>'
                               onchange ="appel('<?php echo $mat."_".$h; ?>')" />
                        <input type = 'text' name = '<?php echo "R_heure_" . $mat."_".$h; ?>' 
                               id = '<?php echo "R_heure_" . $mat."_".$h; ?>' size = '2' />
                    </td>
                    <?php
                    if ($i != count($horaires)) {
                        $class = "foncee";
                    } else {
                        $class = "";
                    }
                    $i++;
                    ?>
                    <td class="<?php echo $class; ?>">
                        <input name = '<?php echo "E_" . $mat."_".$h; ?>' value = '<?php echo "E_" . $mat."_".$h; ?>' type="checkbox" 
                               onchange ="exclu('<?php echo $mat."_".$h; ?>')" />
                        <input type = 'text' name = '<?php echo "E_heure_" . $mat."_".$h; ?>' 
                               id = '<?php echo "E_heure_" . $mat."_".$h; ?>' size = '2' />
                    </td>
        <?php } ?>
            </tr>
                <?php
            }
            $str = substr($str, 0, strlen($str) - 1);
          
            ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $("<?php echo $str; ?>").datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 5,
            value: '00:00'
        });
        $("<?php echo $str; ?>").css({display: 'none'});

    });
</script>