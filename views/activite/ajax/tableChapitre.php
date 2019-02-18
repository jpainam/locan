<label>Chapitre : </label>
<input type="text" name="txtchapitre" size="30" /> 
<img style="cursor: pointer; vertical-align: bottom" src="<?php echo img_add(); ?>" 
     onclick="ajouterChapitre(<?php echo $activite['IDACTIVITE']; ?>);"/>
<br/>
<span style="font-size: 10px;margin:0; padding:0">Activit&eacute; : <?php echo $activite['TITRE']; ?> </span>
<table class="dataTable" id="tableChapitre">
    <thead><tr><th>N°</th><th>Titre</th><th></th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($chapitres as $chap) {
            echo "<tr><td>" . $i . "</td><td>" . $chap['TITRE'] . "</td>";
            echo "<td align='center'>";
            if (isAuth(525)) {
                echo "<img style='cursor:pointer' src='" . img_edit() . "'  "
                . "onclick=\"modifierChapitre(" . $chap['IDCHAPITRE'] . "," . $chap['ACTIVITE'] . ")\" />&nbsp;&nbsp;";
            } else {
                echo "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />&nbsp;&nbsp;";
            }
            if (isAuth(524)) {
                echo "<img style='cursor:pointer' src='" . img_delete() . "' "
                . "onclick=\"supprimerChapitre(" . $chap['IDCHAPITRE'] . ", " . $chap['ACTIVITE'] . ")\" />";
            } else {
                echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
            }
            echo "</td><td align='center'>"
            . "<img style='cursor:pointer' title='Ajouter des lecons a ce chapitre' src='" . img_plus() . "' "
            . "onclick=\"chargerLecon(" . $chap['IDCHAPITRE'] . ");\"  /></td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableChapitre")) {
            $("#tableChapitre").DataTable({
                bInfo: false,
                paging: false,
                scrollY: 100,
                searching: false,
                columns: [
                    {"width": "5%"},
                    null,
                    {"width": "15%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>
