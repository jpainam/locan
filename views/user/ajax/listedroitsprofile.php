<table id="tabledroits" class="dataTable">
    <thead>
        <tr><th>Code</th><th>Description du droits</th><th></th></tr>
    </thead>
    <tbody>
        <?php 
        $droitsprofile = is_null($droitsprofile) ? array() : $droitsprofile;
        
        foreach($droits as $d){
            echo "<tr><td style='border-left:1px solid #000'>".$d['CODEDROIT']."</td><td>".$d['LIBELLE']."</td><td>";
            if (in_array($d['CODEDROIT'], $droitsprofile)) {
                echo "<input type = 'checkbox' name = 'droits[]' checked value = '" . $d['CODEDROIT'] . "' />";
            } else {
                echo "<input type = 'checkbox' name = 'droits[]' value = '" . $d['CODEDROIT'] . "' />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function () {
        if(!$.fn.DataTable.isDataTable("#tabledroits")){
            $("#tabledroits").DataTable({
               bInfo: false,
               paging: false,
               columns : [
                   {"width" : "10%"},
                   null,
                   {"width" : "5%"}
               ]
            });
        }
    });
</script>