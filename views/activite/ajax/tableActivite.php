<label>Activit&eacute; : </label> <input type="text" size="30" name="txtactivite" />
<img  style="cursor: pointer;vertical-align: bottom" src="<?php echo img_add(); ?>" 
      onclick="ajouterActivite();"/>
<br/><br/>
<table class="dataTable" id="tableActivite">
    <thead><tr><th>N°</th><th>Titre</th><th></th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($activites as $act) {
            echo "<tr><td>" . $i . "</td><td>" . $act['TITRE'] . "</td>";
            echo "<td align='center'>";
            if (isAuth(525)) {
                echo "<img style='cursor:pointer' src='" . img_edit() . "' "
                . "onclick=\"modifierActivite(" . $act['IDACTIVITE'] . ")\" />&nbsp;&nbsp;";
            } else {
                echo "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />&nbsp;&nbsp;";
            }
            if (isAuth(524)) {
                echo "<img style='cursor:pointer' src='" . img_delete() . "' onclick=\"supprimerActivite(" . $act['IDACTIVITE'] . ")\" />";
            } else {
                echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
            }
            echo "</td><td align='center'>"
            . "<img style='cursor:pointer' title='Ajouter les chapitres de cette activite' src='" . img_plus() . "' "
            . "onclick=\"chargerChapitre(" . $act['IDACTIVITE'] . ");\"  /></td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableActivite")) {
            $("#tableActivite").DataTable({
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

