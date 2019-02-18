<div id="entete">
    <div style="margin-left: 80px">
        <span class="select" style="width: 350px"><label>Mati&egrave;res : </label><?php echo $comboClasses; ?></span>
        <span class="select" style="width: 200px"><label>P&eacute;riode : </label><?php echo $comboPeriodes; ?></span>
    </div>
</div>
<div class="page">
    <div id="notes-content">
        <?php echo $tableNotes; ?>
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
