<table class="dataTable" id="tableChapitre">
    <thead><tr><th>N°</th><th>Activit&eacute;s</th><th>Chapitres</th><th>S&eacute;quences</th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        $previous = 0;
        foreach ($chapitres as $chap) {
            echo "<tr>";
            if ($previous != $chap['ACTIVITE']) {
                $nb = nbChapitres($chap['ACTIVITE'], $chapitres);
                echo "<td rowspan = '" . $nb . "'>" . $i . "</td>"
                . "<td rowspan = '" . $nb . "'>" . $chap['TITREACTIVITE'] . "</td>";
                $i++;
            }
            $previous = $chap['ACTIVITE'];
            echo "<td>" . $chap['TITRECHAPITRE'] . "</td><td>";
            echo "<select name = 'seq" . $chap['IDCHAPITRE'] . "' style='margin:2px'>"
            . "<option value=''></option>";
            foreach ($sequences as $seq) {
                echo "<option value ='" . $seq['IDSEQUENCE'] . "' "
                . ($chap['SEQUENCE'] == $seq['IDSEQUENCE'] ? "selected" : "") . ">" . $seq['LIBELLE'] . "</option>";
            }
            echo "</select>";
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>
<input type="hidden" value="true" name="programmation" />
<script>
    $(document).ready(function () {
       /* if (!$.fn.DataTable.isDataTable("#tableChapitre")) {
            $("#tableChapitre").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 60,
                bSort: false,
                columns: [
                    {"width": "5%"},
                    null,
                    null,
                    {"width": "15%"}
                ]
            });
        }*/
    });
</script>