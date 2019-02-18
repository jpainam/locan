<div id="entete">
    <div class="logo">

    </div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 300px">
            <label>Du</label><input type="text" name="datedu" id="datedu" />
        </span>
        <span class="text" style="width: 300px">
            <label>Au</label><input type="text" name="dateau" id="dateau" />
        </span>
    </div>

</div>
<div class="page">
    <div id="absence-content" style="height: 95%">
        <?php 
        echo $discipline;
        ?>
    </div>
    <!-- p style="margin:5px 10px 0 10px; padding: 0">
        <?php //echo $legendes; ?>
    </p -->
</div>
<div class="recapitulatif">

</div>
<div class="navigation">

    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0007">R&eacute;capitulatif des absences des enseignants</option>
        </select>
    </div>
</div>
<div class="status">

</div>
