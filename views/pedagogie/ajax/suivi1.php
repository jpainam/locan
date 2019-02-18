<table class="dataTable" id="tableSuivi">
    <thead><tr><th>N° Seq</th><th>Activit&eacute;s</th><th>Chapitres</th><th>Le&ccedil;ons</th><th></th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($programmation as $prog) {
            if($prog['ORDRE'] == 1){
                echo "<tr><td>1<sup>&eacute;re</sup></td>";
            }else{
                echo "<tr><td>" . $prog['ORDRE'] . "<sup>&egrave;me</sup></td>";
            }
            echo "<td>" . $prog['TITREACTIVITE'] . "</td><td>" . $prog['TITRECHAPITRE'] . "</td>"
            . "<td>" . $prog['TITRELECON'] . "</td>";
            if ($prog['ETAT'] == 0) {
                echo "<td class='absent'>";
            } else {
                echo "<td class='present'>";
            }
            echo "<select name='prog" . $prog['IDPROGRAMMATION'] . "' onchange = 'choisir(this)'><option value='' ></option>"
            . "<option value='0' " . ($prog['ETAT'] == 0 ? "selected" : "") . ">Non fait</option>"
            . "<option value='1' " . ($prog['ETAT'] == 1 ? "selected" : "") . ">Deja fait</option>"
            . "</select>";
            echo "</td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableSuivi")) {
            $("#tableSuivi").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 120,
                columns: [
                    {"width": "10%"},
                    null,
                    null,
                    null,
                    {"width": "10%"}
                ]
            });
        }
    });
</script>