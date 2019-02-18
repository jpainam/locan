<div id="entete">
    <div style="margin-left: 80px">
        <span class="select" style="width: 350px"><label>Mati&egrave;res - classes : </label>
            <?php echo $comboEnseignements; ?>
        </span>
        <span class="select" style="width: 200px"><label>P&eacute;riode : </label>
            <?php echo $comboPeriodes; ?>
        </span>
    </div>
</div>
<div class="page">
    <div id="verrouillage-content">
        <?php echo $verrouillage; ?>
    </div>
</div>
<div class="navigation">
    <?php
    if(isAuth(401)){
        echo btn_add("document.location='".Router::url("note", "saisie")."'");
    }else{
        echo btn_add_disabled();
    }
    ?>
</div>
<div class="status"></div>
