<table id="tableusers" class="dataTable">
    <thead>
        <tr><th></th><th>Noms et Pr&eacute;noms</th><th></th></tr>
    </thead>
    <tbody>
        <?php 
        foreach($usersprofile as $u){
            echo "<tr><td>".$u['CIVILITE']."</td><td>".$u['NOM']." ".$u['PRENOM']."</td><td>"
                    . "<input type='checkbox' name='usersprofile[]' value = '" . $u['USER'] . "' checked='checked' /></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if(!$.fn.DataTable.isDataTable("#tableusers")){
            $("#tableusers").DataTable({
               bInfo: false,
               paging: false,
               columns : [
                   {"width" : "5%"},
                   null,
                    {"width" : "5%"}
               ]
            });
        }
    });
</script>