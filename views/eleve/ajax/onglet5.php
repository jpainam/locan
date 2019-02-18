<table class='dataTable' id='tableNotes'>
    <thead><tr><th>S&eacute;quences</th><th>Mati&egrave;res</th><th>Description</th>
            <th>Date</th><th>Notes</th><th></th></tr>
    </thead><tbody>
        <?php
        foreach ($notes as $n) {
            $d = new DateFR($n['DATEDEVOIR']);
            echo "<tr><td>" . $n['LIBELLEHTML'] . "</td><td>" . $n['BULLETIN'] . "</td><td>" . $n['DESCRIPTION'] . "</td>"
            . "<td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear(2) . "</td>"
            . "<td align='right'>" . ($n['ABSENT'] ? "" : $n['NOTE']) . "</td>"
            . "<td align='center'><img style='cursor:pointer' src='" . img_info() . "' "
            . "onclick = \"tooltip_on(event,'" . $n['IDNOTATION'] . "')\" />&nbsp;&nbsp;";
            if (isAuth(407) && $n['VERROUILLER'] != 1) {
                echo "<img src='" . img_edit() . "' onclick ='showEditerNote(" . $n['IDNOTE'] . ", this)' style='cursor:pointer' />&nbsp;&nbsp;";
            } else {
                echo "<img src='" . img_edit_disabled() . "' style='cursor:pointer' />&nbsp;&nbsp;";
            }
            if (isAuth(409) && $n['VERROUILLER'] != 1) {
                echo "<img src='" . img_delete() . "' "
                . "onclick =\"deleteNote(" . $n['IDNOTE'] . ",'" . $n['BULLETIN'] . "')\" style='cursor:pointer' />";
            } else {
                echo "<img src='" . img_delete_disabled() . "' style='cursor:poiner' />";
            }
            echo "</td></tr>";
        }
        ?>
    </tbody></table>
<script>
    $(document).ready(function () {
        $("#tableNotes").dataTable({
            scrollY: $(".page").height() - 170,
            bInfo: false,
            columns: [
                {width: "10%"},
                null,
                {width: "30%"},
                {width: "10%"},
                {width: "5%"},
                {width: "10%"}
            ]
        });


    });
</script>
<?php foreach ($notations as $n) { ?>
    <div style="max-height: 150px; overflow: auto; left: 829px; top: 112px; display: none;font-size: 11px" 
         onmouseout="tooltip_off(<?php echo $n['IDNOTATION']; ?>)" onmouseover="tooltip_stop(<?php echo $n['IDNOTATION']; ?>)"
         class="edt_tooltip" id="tooltip<?php echo $n['IDNOTATION'] ?>">
        <p style="font-weight: bold"><?php echo $n['MATIERELIBELLE']; ?></p>
        <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note sur :</span>
        <span style="width:45px; display:inline-block;"><b><?php echo $n['NOTESUR']; ?></b></span>

        <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note mini :</span>
        <span style="width:35px; display:inline-block;"><?php echo $n['NOTEMIN'] ?></span>

        <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note maxi :</span>
        <span style="width:35px; display:inline-block;"><?php echo $n['NOTEMAX'] ?></span>

        <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note moyenne :</span>
        <span style="width:35px; display:inline-block;"><?php echo substr($n['NOTEMOYENNE'], 0, 4); ?></span>

    </div>
    <?php
}

