<?php
//Appel deja realise
if (isset($deja)) {
    echo '<p style="color: #ff9999;text-align: center;margin: auto;width:750px;">Appel d&eacute;j&agrave; r&eacute;alis&eacute;<br/>';
    if (isAuth(320)) {
        echo "Proc&eacute;dez &agrave; <a href='" . Router::url("appel", "edit", $idappel) . "'>l'&eacute;dition ici</a>";
    } else {
        echo "Vous n'&ecirc;tes pas autoris&eacute;s &agrave effectuer une modification";
    }
    echo "</p>";
}
?>

<table class="dataTable" id="appelTable">
    <thead><tr><th>Matricule</th><th>Nom & Pr&eacute;nom</th><th>Pr&eacute;sent</th><th>Absent</th><th>Retard</th><th>Exclu</th></tr></thead>
    <tbody><?php
        //Appel deja ou non realise
        $str = "";
        if (!isset($deja)) {
            foreach ($eleves as $el) {
                $mat = $el['MATRICULE'];
                $str .= "#R_heure_" . $mat . ", #E_heure_" . $mat . ",";
                ?>
                <tr><td><?php echo $mat; ?></td><td><?php echo $el['CNOM']; ?></td><td align='center'>
                        <!-- Presence -->
                        <input <?php echo isset($deja) ? "disabled" : ''; ?> type = 'radio' name = '<?php echo $mat; ?>' value = '<?php echo "P_" . $mat; ?>' checked='checked' onchange ="appel('<?php echo $mat; ?>')" /></td><td align='center'>
                        <!-- Absence -->
                        <input <?php echo isset($deja) ? "disabled" : ''; ?> type = 'radio' name = '<?php echo $mat; ?>' value = '<?php echo "A_" . $mat; ?>' onchange ="appel('<?php echo $mat; ?>')" /></td><td align='center'>
                        <!-- Retard -->
                        <input type = 'radio' name = '<?php echo $mat; ?>' value = '<?php echo "R_" . $mat; ?>' onchange ="appel('<?php echo $mat; ?>')" />
                        <input type = 'text' name = '<?php echo "R_heure_" . $mat; ?>' id = '<?php echo "R_heure_" . $mat; ?>' size = '2' /></td>
                    <!-- Exclusion -->
                    <td align='center'><input onchange ="exclu('<?php echo $mat; ?>')" type = 'checkbox' name = '<?php echo "E_" . $mat; ?>' value = '<?php echo "E_" . $mat; ?>'  />
                        <input type = 'text' name = '<?php echo "E_heure_" . $mat; ?>' id = '<?php echo "E_heure_" . $mat; ?>' size = '2' /></td></tr>
                <?php
            }
            $str = substr($str, 0, strlen($str) - 1);
        } else {
           
            foreach($absences as $abs){
                echo "<tr><td>".$abs['MATRICULE']."</td><td>".$abs['NOM']." ".$abs['PRENOM']."</td>";
                if(is_null($abs['IDABSENCE'])){
                    echo "<td align='center'><input checked disabled type = 'radio' /></td>";
                }else{
                    echo "<td align='center'><input  disabled type='radio' /></td>";
                }
                if(is_null($abs['IDABSENCE'])){
                    echo "<td align='center'><input disabled type = 'radio' /></td>";
                }else{
                    echo "<td align='center'><input ".($abs['ETAT'] === 'A' ? "checked":"")." type='radio' disabled /></td>";
                }
                if(is_null($abs['IDABSENCE'])){
                    echo "<td align='center'><input disabled type='radio' /></td>";
                }else{
                    echo "<td align='center'><input disabled ".($abs['ETAT'] === 'R' ? "checked":"")." type = 'radio' />";
                }
                if(isset($abs['ETAT']) && ($abs['ETAT'] === 'R')){
                    echo "<input disabled type = 'text' value = '".$abs['RETARD']."' size = '2' />";
                }
                echo "</td>";
                if(is_null($abs['IDABSENCE'])){
                    echo "<td align='center'><input type='checkbox' disabled /></td>";
                }else{
                    echo "<td align='center'><input disabled ".(!empty($abs['EXCLU']) ? "checked":"")." type = 'checkbox' />";
                    if(!empty($abs['EXCLU'])){
                        echo "<input type = 'text' disabled value = '".$abs['EXCLU']."' size = '2' disabled />";
                    }
                }
                echo "</td></tr>";
            }
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#appelTable")) {
            $("#appelTable").DataTable({
                "bInfo": false,
                "paging": false,
                "columns": [
                    {"width": "10%"},
                    null,
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "7%"},
                    {"width": "7%"}
                ]
            });
        }
        $("<?php echo $str; ?>").datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 5,
            value: '00:00'
        });
        $("<?php echo $str; ?>").css({display: 'none'});

    });
</script>
