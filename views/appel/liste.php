<div id="entete" style="height: 80px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 160px; margin-top: 0"><label>Semaine du : </label>
            <div style="margin-top: 10px" id="datedebut"></div></span>
        <span class="text" style="width: 160px; margin-top: 0"><label>Au </label>
            <div id="datefin" style="margin-top: 10px"></div></span>    
        <span class="select" style="width: 330px; clear: both;margin-top: 0"><label>Classes : </label><?php echo $comboClasses; ?></span>
    </div>
</div>
<div class="page">

    <div id="listeappel" style="width: 100%;height: 95%;max-height: 95%;overflow: auto;background-color: #FFF;"></div>
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
    <div class="editions">
        <img src="<?php echo img_imprimer(); ?>" />&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Imprimer une liste d'appel vierge</option>
            <option value="0002">Imprimer cette liste d'appel</option>
        </select>
    </div>
</div>
<div class="status"></div>