<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_operation.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 150px"><label> Du : </label>
            <input id="datedebut" name="datedebut" /></span>

        <span class="text" style="width: 150px"><label> Au  : </label>
            <input name="datefin" id="datefin" />``</span>

        <span class="select" style="width: 320px; clear: left;margin-top: 0;">
            <label> Type d'op&eacute;ration : </label>
            <select name="typeoperation">
                <option value=""></option>
                <option value="1">En cours</option>
                <option value="2">Valid&eacute;es</option>
                <option value="3">Non per&ccedil;ues</option>
            </select>
        </span>
    </div>
</div>
<?php
if (isAuth(532)) {
    $_maxnbre = 3;
} else {
    $_maxnbre = 2;
}
if(isAuth(537)){
    $_maxnbre = $_maxnbre + 1;
}
if(isAuth(538)){
    $_maxnbre = $_maxnbre + 1;
}
?>
<div class="page">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant"><a onclick="onglets(1, 1, <?php echo $_maxnbre; ?>);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/operation.png"; ?>" />&nbsp;Op&eacute;rations caisses</a></li>
            <li id="tab2" class="noncourant"><a onclick="onglets(1, 2, <?php echo $_maxnbre; ?>);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/caisse.png"; ?>" />&nbsp;Totaux</a></li>
            <?php if (isAuth(532)) { ?>
                <li id="tab3" class="noncourant"><a onclick="onglets(1, 3, <?php echo $_maxnbre; ?>);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/opsupprimees.png"; ?>" />&nbsp;Op&eacute;rations supprim&eacute;es</a></li>
            <?php }
            if (isAuth(537)) { ?>
                <li id="tab4" class="noncourant"><a onclick="onglets(1, 4, <?php echo $_maxnbre; ?>);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/remise.png"; ?>" />&nbsp;Remises Effectu&eacute;es</a></li>
            <?php }
            if (isAuth(538)) { ?>
                <li id="tab5" class="noncourant"><a onclick="onglets(1, 5, <?php echo $_maxnbre; ?>);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/moratoire.png"; ?>" />&nbsp;
                        Moratoires</a></li>
            <?php } ?>
        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block; height: 90%;">
        <?php echo $tableOperation; ?>
    </div>
    <div id="onglet2" class="onglet" style="display: none; height: 90%;">
        <table class="dataTable" id="tableTotaux">
            <thead><tr><th>Montant non valid&eacute;e</th><th>Montant per&ccedil;u</th><th>Montant valid&eacute;</th></tr></thead>
            <tbody>
                <tr style="text-align: right;"><td><?php echo moneyString($totaux['MONTANTNONVALIDE']); ?></td>
                    <td><?php echo moneyString($totaux['MONTANTNONPERCU']); ?></td>
                    <td><?php echo moneyString($totaux['MONTANTVALIDE']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="onglet3" class="onglet" style="display: none; height: 90%;">
        <?php echo $operationSupprimes; ?>
    </div>
     <div id="onglet4" class="onglet" style="display: none; height: 90%;">
        <?php echo $operationsRemises; ?>
    </div>
     <div id="onglet5" class="onglet" style="display: none; height: 90%;">
        <?php echo $moratoires; ?>
    </div>
</div>
<div class="navigation">
    <div class="editions" style="float: left;">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0003">Imprimer la liste des &eacute;l&egrave;ves d&eacute;biteurs</option>
            <option value="0004">Imprimer la liste des &eacute;l&egrave;ves cr&eacute;diteurs</option>
        </select>
    </div>
</div>
<div class="status"></div>