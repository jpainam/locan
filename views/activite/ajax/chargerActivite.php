<style>
    #tableActivite tbody tr{
        cursor: pointer;
    }
</style>
<table class="dataTable" id="tableActivite">
    <thead><tr><th>N°</th><th>Titre</th></tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($activites as $act) {
            echo "<tr><td><input type='hidden' value='" . $act['IDACTIVITE'] . "' />"
            . $i . "</td><td>" . $act['TITRE'] . "</td></tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableActivite")) {
            var tab = $("#tableActivite").DataTable({
                bInfo: false,
                paging: false,
                searching: false,
                scrollY: $(".page").height() - 120,
                columns: [
                    {"width": "5%"},
                    null
                ]
            });

            tab.row().on("click", function (e) {
                var tr = e.target.parentNode, td = tr.firstChild, input = td.firstChild;
                
                if(input.value === undefined){
                    return;
                }
           
                $.ajax({
                    url: "./activite/ajaxindex",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "chargerChapitre",
                        idactivite: input.value
                    },
                    success: function (result) {
                        $("#chapitre-content").html(result[0]);
                    },
                    error: function (xhr, status, error) {
                        alert("Une erreur s'est produite " + xhr + " " + error);
                    }
                });
            });
        }
    });
</script>

