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
            <thead><th>Matricule</th><th>Noms & Pr&eacute;noms</th><th>Note</th><th>Non not&eacute;</th><th>Observations</th></thead>
            <tbody>
                <?php
                
                foreach ($eleves as $el) {
                    $ideleve = $el['IDELEVE'];
                    $note = getNote($ideleve, $notes);

                    if (is_null($note)) {
                        $idnote = "";
                        $sanote = "";
                        $estabsent = 0;
                        $observation = "";
                    } else {
                        $idnote = $note['IDNOTE'];
                        $sanote = $note['NOTE'];
                        $estabsent = $note['ABSENT'];
                        $observation = $note['OBSERVATION'];
                    }
                    if($estabsent === 1){
                        $sanote = "";
                    }
                    echo "<tr><td>" . $el['MATRICULE'] . "<input type='hidden' name='id_" . $ideleve . "' value='" . $idnote . "' /></td>";
                    echo "<td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
                    echo "<td align='center'><input style=\"text-align: right\" onKeyUp = \"noter('" . $ideleve . "');\" "
                    . "type = 'text' name = 'note_" . $ideleve . "' size = '2' value = '" . $sanote . "' /></td>";
                    /*if ($estabsent === 1) {
                        echo "<td align='center'><input name = 'absent_" . $ideleve . "' type = 'checkbox' checked='checked' /></td>";
                    } else {
                        echo "<td align='center'><input name = 'absent_" . $ideleve . "' type ='checkbox' /></td>";
                    }*/
                    if (empty($sanote)) {
                        echo "<td align='center'><input type='checkbox' name='nonNote_" . $ideleve . "' checked='checked'  /></td>";
                    } else {
                        echo "<td align='center'><input type='checkbox' name='nonNote_" . $ideleve . "' /></td>";
                    }
                    echo "<td align='center'><input type='text' name = 'observation_" . $ideleve . "' value='" . $observation . "'  "
                            . "size = '30' /></td></tr>";
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
<?php

function getNote($ideleve, $notes) {
    foreach ($notes as $n) {
        if ($n['ELEVE'] === $ideleve) {
            return $n;
        }
    }
    return null;
}