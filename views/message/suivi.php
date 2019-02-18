<div id="entete" style="height: 80px">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_telephone.png"; ?>" />
    </div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 180px; margin-top: 0"><label>De</label>
            <div style="margin-top: 10px" id="datede"></div></span>
        <span class="text" style="width: 150px; margin-top: 0"><label>Au</label>

            <div style="margin-top: 10px" id="dateau"></div></span>
        <span class="select" style="width: 350px; clear: both; margin-top: 0">
            <label>Filtrer par destinataires</label>
            <?php echo $comboDestinataires; ?>
        </span>
    </div>
</div>
<div class="page">
    <div id="message-content">
        <?php
        echo $tableMessages;
        ?>
    </div>
</div>
<div class="navigation">

</div>
<div class="status">

</div>