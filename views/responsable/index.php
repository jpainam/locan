<style>
#page-content span.select2{
    width: 400px !important;
}
</style>
<div id="entete">
     <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_personnel.png"; ?>" /></div>
    <div style="margin-left: 120px">
        <span class="select2" >
            <label>Liste des parents d'&eacute;l&egrave;ves: </label>
            <select name="responsable">
                <option value=""></option>
                <?php 
                foreach($responsables as $resp){
                    echo "<option value='".$resp['IDRESPONSABLE']."'>".$resp['NOM'].' '.$resp['PRENOM']."</option>";
                }
                ?>
            </select>
        </span>
    </div>
</div>
<div class="titre"></div>
<div class="page">
</div>
<div class="navigation">
    <?php if(isAuth(319)){
        echo btn_add("document.location='".Router::url("responsable", "saisie")."'");
    }else{
        echo btn_add_disabled();
    }
    ?>
</div>
<div class="status"></div>