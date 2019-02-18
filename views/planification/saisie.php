<div id="entete">
    <div class="logo">
        
    </div>
    <div style="margin-left: 25px">
        <span class="select" style="width: 100px"><label>Classes : </label>
            <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 250px"><label>Mati&egrave;res : </label>
            <select name="comboMatieres"><option value=""></option></select>
        </span>
        <span class="select" style="width: 150px"><label>S&eacute;quences : </label>
            <select name="comboSequences"><option value=""></option></select>
        </span>
        <span class="select" style="width: 100px"><label>Nbre d'heures : </label>
            <select name="comboHeures"><option value=""></option>
            <?php 
            for($i = 1; $i < 250; $i++){
                echo "<option value = '".$i . "'>".$i."</option>";
            }
            ?>
            </select>
        </span>
        <span style="width: 150px; display: inline-block;margin-top: 20px">
            <?php echo btn_add("ajouterPlanification()"); ?>
        </span>
    </div>
</div>