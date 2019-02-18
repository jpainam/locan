<table class="dataTable" id="tableFinance">
    <thead><tr><th>Matricule</th><th>Noms et Pr&eacute;noms</th>
            <th>Redoublant</th><th>Total vers&eacute;</th><th>Solde</th><th></th><th></th></tr></thead>
    <tbody>
        <?php
        if (!is_array($array_of_redoublants)) {
            $array_of_redoublants = array();
        }
        foreach ($soldes as $el) {
            echo "<tr><td>" . $el['MATRICULE'] . "</td><td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";

            if (in_array($el['IDELEVE'], $array_of_redoublants)) {
                echo "<td align = 'center'><input type = 'checkbox' disabled checked /></td>";
            } else {
                echo "<td align = 'center'><input type = 'checkbox' disabled /></td>";
            }

            echo "<td align ='right'>" . moneyString($el['MONTANTPAYE']) . "</td>";
            echo "<td align ='right'>" . moneyString($el['MONTANTPAYE'] - $montanfraisapplicable)  . "</td>";
            
            if($el['MONTANTPAYE'] >= $montanfraisapplicable){
                 echo "<td style='background-color:#99ff99;text-align:center'>#C#</td>";
            }else{
                 echo "<td style='background-color:#ff9999;text-align:center'>#D#</td>";
            }
           
            echo "<td align ='center'><img style='cursor:pointer' title='Imprimer le compte de cet &eacute;l&egrave;ves' "
            . "src='" . img_print() . "' onclick=\"imprimerCompte(" . $el['IDELEVE'] . ")\"></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableFinance")) {
            $("#tableFinance").DataTable({
                
                scrollY: $(".page").height() - 160,
                "columns": [
                    {"width": "7%"},
                    null,
                    {"width": "12%"},
                    {"width": "12%"},
                    {"width": "12%"},
                    {"width": "5%"},
                    {"width": "5%"}
                ]
            });
        }
    });
</script>