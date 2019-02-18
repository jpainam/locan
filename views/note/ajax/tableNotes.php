<?php
foreach($notations as $n){?>
<div style="max-height: 150px; overflow: auto; left: 829px; top: 112px; display: none;font-size: 11px" 
     onmouseout="tooltip_off(<?php echo $n['IDNOTATION']; ?>)" onmouseover="tooltip_stop(<?php echo $n['IDNOTATION']; ?>)"
            class="edt_tooltip" id="tooltip<?php echo $n['IDNOTATION'] ?>">
    <p style="font-weight: bold"><?php echo  $n['MATIERELIBELLE'] . " - " . $n['CLASSELIBELLE']; ?></p>
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note sur :</span>
    <span style="width:45px; display:inline-block;"><b><?php echo $n['NOTESUR']; ?></b></span>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note mini :</span>
    <span style="width:35px; display:inline-block;"><?php echo $n['NOTEMIN'] ?></span>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note maxi :</span>
    <span style="width:35px; display:inline-block;"><?php echo $n['NOTEMAX'] ?></span>
    
    <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note moyenne :</span>
    <span style="width:35px; display:inline-block;"><?php echo substr($n['NOTEMOYENNE'], 0, 4); ?></span>

</div>
<?php } ?>

<table class="dataTable" id="tableNotes">
    <thead><th>Date</th><th>P&eacute;riode</th><th><img src="<?php echo img_lock(); ?>" /></th>
    <th><img src='<?php echo img_phone(); ?>' /></th>
    <th>Mati&egrave;re - classe</th><th>Coeff.</th><th>Libell&eacute; du devoir</th><th></th></thead>
<tbody>
    <?php
    foreach ($notations as $n) {
        $d = new DateFR($n['DATEDEVOIR']);
        echo "<tr><td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td><td>" . $n['SEQUENCELIBELLE'] . "</td>";
        if ($n['NOTATIONVERROUILLER'] == 1) {
            echo "<td align='center'><input type='checkbox' checked disabled='disabled' /></td>";
        } else {
            echo "<td align='center'><input disabled='disabled' type='checkbox' /></td>";
        }
        echo "<td title='Nombre de notification envoy&eacute; aux parents' align='center'>".$n['NOTIFICATION']."</td>";
        echo "<td>" . $n['BULLETIN'] . " - " . $n['NIVEAUHTML'] . "</td><td align='right'>" . $n['COEFF'] . "</td>";
        echo "<td>" . $n['DESCRIPTION'] . "</td><td align='center'><img style='cursor:pointer' src='" . img_info() . "'
                 onclick = \"tooltip_on(event,'".$n['IDNOTATION']."')\" />&nbsp;&nbsp;";
        echo "<img style='cursor:pointer' src='".img_phone_add()."' onclick=\"notifierNotation(".$n['IDNOTATION'].")\" />&nbsp;&nbsp;";
        echo "<img style='cursor:pointer' src='".img_print()."' onclick=\"impression(".$n['IDNOTATION'].")\" />&nbsp;&nbsp;";
        
        if (isAuth(407) && $n['NOTATIONVERROUILLER'] != 1) {
            echo "<img style='cursor:pointer' src='" . img_edit() . "' onclick=\"editNotation(".$n['IDNOTATION'].")\" />&nbsp;&nbsp;";
        } else {
            echo "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />&nbsp;&nbsp;";
        }
        
        if ($n['NOTATIONVERROUILLER'] == 1) {
            echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
        } elseif (isAuth(409)) {
            echo " | <img style='cursor:pointer' src='" . img_delete() . "' onclick=\"supprimerNotation(".$n['IDNOTATION'].")\" />";
        } else {
            echo "<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
        }
        echo "</td></tr>";
    }
    ?>
</tbody>
</table>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableNotes")) {
            $("#tableNotes").DataTable({
                columns: [
                    {"width": "10%"},
                    {"width": "12%"},
                    {"width": "3%"},
                    {"width": "3%"},
                    null,
                    {"width": "5%"},
                    null,
                    {"width": "17%"}
                ]
            });
        }
    });
</script>