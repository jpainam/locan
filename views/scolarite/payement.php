<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT."public/img/wide_scolarite.png"; ?>" />
    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px;margin-top: 0"><label>Classes : </label>
        <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 250px; margin-top: 0"><label>Frais &agrave; pay&eacute;s</label>
            <select name="comboFrais" id="comboFrais">
                <option></option>
            </select>
        </span>
        <br/><br/><br/>
        <span>Montant du frais : </span>
        <span id="montantFrais" style="width: 165px; display: inline-block;">
            ________________________</span>
        <span>Ech&eacute;ance : </span><span  id="echeanceFrais">
            _______________________</span>
    </div>
</div>
<div class="page">
    <div id="scolarite-content">
        
    </div>
</div>
<div class="navigation">
    <?php 
    //autorisation pour consulter les infos de la classe
    
    if(isAuth(202)){
        echo btn_ok("document.location='".Router::url("classe")."'");
    }
    ?>
</div>
<div class="status"></div>