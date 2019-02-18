<table class="dataTable" id="tableNotes">
    <thead><tr><th>N°</th><th>Activit&eacute;s</th><th>Chapitres</th><th>Chapitres faits ou non fait</tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($chapitres as $chap) {

            echo "<tr><td>" . $i . "</td><td>" . $chap['TITREACTIVITE'] . "</td><td>" . $chap['TITRECHAPITRE'] . "</td>";
            # Si toutes les lecons de ce chapitre son faite, alors afficher fait en vert
            if (chapitreFait($chap['IDCHAPITRE'], $programmation)) {
                echo "<td class='present' align='center'>Fait</td>";
            } else {
                echo "<td class='absent' align='center'>Non Fait</td>";
            }
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableNotes")) {
            $("#tableNotes").DataTable({
                bInfo: false,
                searching: false,
                paging: false,
                scrollY: $(".page").height() - 120,
                columns: [
                    {"width": "7%"},
                    null,
                    null,
                    null
                ]
            });
        }
    });
</script>
<?php 
function chapitreFait($idchapitre, $programmation){
    foreach($programmation as $prog){
        if($prog['IDCHAPITRE'] == $idchapitre && $prog['ETAT'] == 0){
            return false;
        }
    }
    return true;
}