<style>
    .dataTable .centrer{
        text-align: center;
    }
</style>
<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 160px; margin-top: 0"><label>Du</label>
            <div style="margin-top: 10px" id="datedu" ></div></span>
        <span class="text" style="width: 160px; margin-top: 0"><label>Au</label>
            <div style="margin-top: 10px" id="dateau"></div></span>

        <span class="select" style="width: 330px; margin-top: 0;clear: both; "><label>Classes : </label>
            <?php echo $comboClasses; ?></span>

    </div>
</div>
<div class="page">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant"><a onclick="onglets(1, 1, 5);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/un.png"; ?>" />&nbsp;&nbsp;Lundi<span></span></a></li>
            <li id="tab2" class="noncourant"><a onclick="onglets(1, 2, 5);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/deux.png"; ?>" />&nbsp;&nbsp;Mardi<span></span></a></li>
            <li id="tab3" class="noncourant"><a onclick="onglets(1, 3, 5);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/trois.png"; ?>" />&nbsp;&nbsp;Mercredi<span></span></a></li>
            <li id="tab4" class="noncourant"><a onclick="onglets(1, 4, 5);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/quatre.png"; ?>" />&nbsp;&nbsp;Jeudi<span></span></a></li>
            <li id="tab5" class="noncourant"><a onclick="onglets(1, 5, 5);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/cinq.png"; ?>" />&nbsp;&nbsp;Vendredi<span></span></a></li>
        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block; height: 85%;">
        <form name="formAppel1" action="" >
        </form>
    </div>
    <div id="onglet2" class="onglet" style="display: none;height: 85%">
        <form name="formAppel2" action="" >
        </form>
    </div>
    <div id="onglet3" class="onglet" style="display: none;height: 85%">
        <form name="formAppel3" action="" >
        </form>
    </div>
    <div id="onglet4" class="onglet" style="display: none;height: 85%">
        <form name="formAppel4" action="" >
        </form>
    </div>
    <div id="onglet5" class="onglet" style="display: none;height: 85%">
        <form name="formAppel5" action="" >
        </form>
    </div>

    <p style="margin:5px 10px 0 10px; padding: 0">
        <label style="font-weight: bold;text-decoration: underline">L&eacute;gendes:</label>&nbsp;&nbsp;
        <span class="present"></span><b>P : </b>Pr&eacute;sent &nbsp;&nbsp;&nbsp; 
        <span class="absent"></span><b>A : </b> Absent &nbsp;&nbsp;&nbsp;
        <span class="retard">R</span><b>R : </b>en Retard &nbsp;&nbsp;&nbsp;
        <span class="exclu">E</span><b>E : </b>Exclu de cours&nbsp;&nbsp;&nbsp;
        <span class="justifier">&nbsp;&nbsp;&nbsp;&nbsp;</span><b>A : </b> Absence justifi&eacute;e
    </p>
</div>
<div class="navigation">
    <div class="editions" style="float: left">&nbsp;
     <img src="<?php echo img_imprimer(); ?>" /><select onchange="imprimer();" name = "code_impression">
        <option></option>
        <option value="0001">Imprimer une liste d'appel vierge</option>
        <option value="0002">Imprimer cette liste d'appel</option>
    </select>
</div>
En cochant cette case, vous certifiez l'exactitude des donn&eacute;es saisies 
en votre nom : <input style="vertical-align: middle;" type="checkbox" name="certifier" />
<?php echo btn_save_appel("validerAppel();"); ?>

</div>
<div class="status"></div>