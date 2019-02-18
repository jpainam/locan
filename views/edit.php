<div id="entete">
    <div style="margin-left: 90px; width: 550px; height: 80px">
        <span class="text" style="width: 200px; margin: 0 10px 0;"><label>Classes : </label>
            <input type="text" value="<?php echo $notation["CLASSELIBELLE"]; ?>" disabled="disabled" /></span>
        <span class="text" style="width: 290px; margin: 0 10px 0"><label>Mati&egrave;res :</label>
            <input type='text' value="<?php echo $notation['MATIERELIBELLE'] ?>" disabled="disabled" /></span>
        <span class="text" style="width: 200px; margin: 0 10px 0"><label>Libell&eacute; du devoir : </label>
            <input type="text" value="<?php echo $notation['DESCRIPTION']; ?>" disabled="disabled" /></span>
        <span class="text" style="width: 150px; margin: 0 10px 0"><label>P&eacute;riode : </label>
            <input type="text" value="<?php echo $notation['SEQUENCELIBELLE']; ?>" disabled="disabled" /></span>
        <span class="text" style="width: 50px; margin: 0 10px 0"><label>Note sur : </label>
            <input type="text" value="20" disabled="disabled" style="text-align: right" /></span>
        <span class="text" style="width: 50px; margin: 0 10px 0"><label>Coef.</label>
            <input style="text-align: right" type="text" value="<?php echo $notation['COEFF']; ?>" disabled="disabled" /></span>
    </div>
</div>
<form action="<?php echo Router::url("note", "edit", $notation['IDNOTATION']); ?>" method="post" name="editNote" >
    <div class="page">
        <table class="dataTable" id="eleveTable">
            <thead><th>Matricule</th><th>Noms & Pr&eacute;noms</th><th>Note</th><th>Absent</th><th>Non not&eacute;</th><th>Observations</th></thead>
            <tbody>
                <?php
                foreach ($notes as $note) {
                    $matric = $note['IDELEVE'];
                    echo "<tr><td>" . $note['MATRICULE'] . "<input type='hidden' name='id_".$matric."' value='".$note['IDNOTE']."' /></td>";
                    echo "<td>" . $note['NOM'] . " " . $note['PRENOM'] . "</td>";
                    echo "<td align='center'><input style=\"text-align: right\" onKeyUp = \"noter('" . $matric . "');\" "
                            . "type = 'text' name = 'note_" . $matric . "' size = '2' value = '" . $note['NOTE'] . "' /></td>";
                    if ($note['ABSENT'] === 1) {
                        echo "<td align='center'><input name = 'absent_" . $matric . "' type = 'checkbox' checked='checked' /></td>";
                    } else {
                        echo "<td align='center'><input name = 'absent_" . $matric."' type ='checkbox' /></td>";
                    }
                    if (empty($note['NOTE'])) {
                        echo "<td align='center'><input type='checkbox' name='nonNote_" . $matric . "' checked='checked'  /></td>";
                    } else {
                        echo "<td align='center'><input type='checkbox' name='nonNote_" . $matric . "' /></td>";
                    }
                    echo "<td align='center'><input type='text' name = 'observation_" .$matric. "' value='".$note['OBSERVATION'] . "'  size = '30' /></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="notation" value="<?php echo $notation['IDNOTATION']; ?>" />
    <input type="hidden" name="idclasse" value="<?php echo $notation['IDCLASSE']; ?>" />
    <div class="navigation">
        <?php
        if(isAuth(407)){
            echo btn_ok("soumettreNotes();");
        }else{
            echo btn_ok_disabled();
        }
        ?>
    </div>
</form>
<div class="status"></div>