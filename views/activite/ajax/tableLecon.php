<label>Le&ccedil;on : </label>
<input type="text" name="txtlecon" size="40" />
<img style="cursor: pointer; vertical-align: bottom" src="<?php echo img_add(); ?>" 
     onclick="ajouterLecon(<?php echo $chapitre['IDCHAPITRE']; ?>);"/><br/>

<span style="font-size: 10px;margin:0; padding:0">Chapitre : <?php echo $chapitre['TITRE']; ?> </span>

<table class="dataTable" id="tableLecon">
    <thead><tr><th>N°</th><th>Titre</th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($lecons as $lecon) {
            echo "<tr><td>" . $i . "</td><td>" . $lecon['TITRE'] . "</td>";
            echo "<td align='center'>";

            if (isAuth(524)) {
                echo "<img style='cursor:pointer' src='" . img_delete() . "' "
                . "onclick=\"supprimerLecon(" . $lecon['IDLECON'] . ", " . $lecon['CHAPITRE'] . ")\" />";
            } else {
                echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
            }
            echo "</td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableLecon")) {
            $("#tableLecon").DataTable({
                bInfo: false,
                paging: false,
                scrollY: 100,
                searching: false,
                columns: [
                    {"width": "5%"},
                    null,
                    {"width": "10%"},
                ]
            });
        }
    });
</script>
