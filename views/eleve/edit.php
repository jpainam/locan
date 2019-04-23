<div id="entete">
    <div class="logo"> <img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
</div>
<script>
    $(document).ready(function () {
        calnaiss = getCalendar("datenaiss");
        calnaiss.setValue("<?php echo $eleve['DATENAISS']; ?>");
        calentree = getCalendar("dateentree");
        calentree.setValue("<?php echo $eleve['DATEENTREE']; ?>");
        calsortie = getCalendar("datesortie");
        calsortie.setValue("<?php echo $eleve['DATESORTIE']; ?>");
    });
</script>
<div class="titre">Modification de l'&eacute;l&egrave;ve : <?php
    echo $eleve['MATRICULE'] . " : " . $eleve['NOM'] . "  " .
    $eleve['PRENOM'];
    ?></div>

<div class="page" style="">
    <div class="tabs" style="width: 100%">
        <ul>
            <li id="tab1" class="courant">
                <a onclick="onglets(1, 1, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                    Informations administratives
                </a>
            </li>
            <li id="tab2" class="noncourant">
                <a onclick="onglets(1, 2, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/responsable.png"; ?>" />
                    Responsables
                </a>
            </li>
            <li id="tab3" class="noncourant">
                <a onclick="onglets(1, 3, 3);">
                    <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/photo.png"; ?>" />
                    Ajout d'une photo d'identit&eacute;
                </a>
            </li>
        </ul>
    </div>
    <div id="onglet1" class="onglet" style="display: block; height: 470px;">
        <form action="<?php echo url('eleve', 'edit', $eleve['IDELEVE']); ?>" name = 'frmeleve' method="post" enctype="multipart/form-data">
            <fieldset style="clear: both; width: 800px"><legend>Identit&eacute;</legend>
                <input type="hidden" name="ideleve" value="<?php echo $eleve['IDELEVE']; ?>" />
                <input type='hidden' name='responsable' value=""/>
                <input type="hidden" name="photoeleve" value="<?php echo $eleve['PHOTO']; ?>" />
                <span class="text" style="width: 250px">
                    <label>Nom</label>
                    <input type="text" name="nomel" value="<?php echo $eleve['NOM']; ?>" maxlength="30" />
                </span>
                <span class="text" style="width: 228px">
                    <label>Pr&eacute;nom</label>
                    <input type="text" value="<?php echo $eleve['PRENOM']; ?>" name="prenomel" maxlength="30" />
                </span>
                <span class="text" style="width: 228px">
                    <label>Autre Nom</label>
                    <input type="text" value="<?php echo $eleve['AUTRENOM']; ?>" name="autrenom" maxlength="30" />
                </span>
                <span class="select" style="width: 255px;margin-right: 10px; clear: both;">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="M" <?php if ($eleve['SEXE'] === "M") echo "selected"; ?>>Masculin</option>
                        <option value="F" <?php if ($eleve['SEXE'] === "F") echo "selected"; ?>>Féminin</option>
                    </select>
                </span>
                <span class="select" style="width: 234px;margin-right: 7px;">
                    <label>Pays de nationalit&eacute;</label>
                    <?php echo $comboNationalite; ?> 
                </span>
                 <span class="text" style="width: 228px; margin-left: 0;"><label>Lieu de r&eacute;sidence : 
                         <input type="text" name="residence" value="<?php echo $eleve['RESIDENCE']; ?>"/>
                </span>
            </fieldset>
            <div style="height: 40px; clear: both; content: ' ';"></div>
            <fieldset style="clear: both; width: 360px">
                <legend>Date et lieu de naissance</legend>
                <span class="text" style="width: 130px">
                    <label>Date de Naissance</label>
                    <input type="text" id="datenaiss" name="datenaiss" value="<?php echo $eleve['DATENAISS']; ?>" />
                </span>
                <span class="select" style="width: 180px; margin-left: 10px;">`
                    <label>Pays de Naiss.</label>
                    <?php echo $comboNaiss; ?>
                </span>
                <span class="text" style="width: 330px">
                    <label>Lieu de Naissance</label>
                    <input type="text" name="lieunaiss" value="<?php echo $eleve['LIEUNAISS']; ?>" maxlength="30" />
                </span>
            </fieldset>
            <fieldset style="width: 419px; margin-left: 5px; float: right;">
                <legend>Informations internes</legend>
                <span class="text" style="width: 150px; margin-right: 22px">
                    <label>CNI</label>
                    <input type="text" name="cni" value="<?php echo $eleve['CNI']; ?>" />
                </span>
                <span class="text" style="width: 222px;" >
                    <label>Identifiant dans l'Etabl.: Matricule</label>
                    <input type="text" name="matricule"  value="<?php echo $eleve['MATRICULE']; ?>" />
                </span>
                <span class="text" style="width: 150px;margin-right: 20px;">
                    <label>Date entr&eacute;e : </label>
                    <input type="text" id="dateentree" name="dateentree" value="<?php echo $eleve['DATEENTREE']; ?>" />
                </span>
                <span class="select" style="width: 230px">
                    <label>Provenance :</label>
                    <?php echo $comboProvenance; ?>
                </span>
                <span class="select" style="width: 155px">
                    <label>Redoublant</label>
                    <select name="redoublant">
                        <option value="0" <?php if ($eleve['REDOUBLANT'] === 0) echo "selected"; ?>>Non</option>
                        <option value="1" <?php if ($eleve['REDOUBLANT'] === 1) echo "selected"; ?>>Oui</option>
                    </select>
                </span>
                <span class="text" style="width: 222px">
                    <label>Classe</label>
                    <input type="text" name="classe" value="<?php echo $classe['LIBELLE']." ".$classe['NIVEAUSELECT'];     ?>" 
                           readonly="readonly" disabled="disabled" />
                </span>
                <span class="text" style="width: 150px;margin-right: 20px;">
                    <label>Date de sortie : </label>
                    <input type="text" id="datesortie" name="datesortie" value="<?php echo $eleve['DATESORTIE']; ?>" />
                </span>
                <span class="select" style="width: 226px">
                    <label>Motif de sortie : </label>
                    <?php echo $comboMotifSortie; ?>
                </span>
            </fieldset>
            <fieldset style="width: 360px; height: 70px;"><legend>Fr&egrave;res et s&oelig;urs</legend>
                <span class="text" style="width: 340px">
                    <label>Noms des fr&egrave;res et s&oelig;urs inscrits &agrave; IPW</label>
                    <input type="text" name="frereetsoeur" value="<?php echo $eleve['FRERESOEUR']; ?>" />
                </span>
            </fieldset>
        </form>
    </div>
    <div id="onglet2" class="onglet" style="display: none; height: 470px;">
        <fieldset style = 'height:446px;width: 300px;'><legend>Responsables</legend>
            <p style="margin: 0 0 5px 0; text-align: right">
                <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" id="ajout-responsable" style="cursor: pointer;" />
            </p>
            <div id="ajout-responsable-dialog-form" class="dialog" title="Selectionner un responsable"><span>
                <label>Choisir un responsable</label>
                <select name='comboResponsable' style="width:100%">
                    <?php
                    foreach ($nonresponsables as $non) {
                        echo "<option value = '" . $non['IDRESPONSABLE'] . "'>" . $non['CIVILITE'] . "-" . $non['NOM'] . " " . $non['PRENOM'] . "</option>";
                    }
                    ?>
                </select></span>
                <span><label>Parent&eacute;</label>
                <?php echo $parenteextra; ?></span><span>
                <?php
                foreach ($charges as $charge) {
                    echo "<input type ='checkbox' value = \"" . $charge['IDCHARGE'] . "\" name = 'chargeextra' />"
                    . $charge['LIBELLE'] . "<br/>";
                }
                ?></span>
            </div>
            <div id="responsable_content">
                <table class="dataTable" id="responsabletable">
                    <thead><tr><th>Civilit&eacute;</th><th>Nom & Pr&eacute;nom</th><th></th></thead>
                    <tbody><?php
                        foreach ($responsables as $resp) {
                            echo "<tr><td>" . $resp['CIVILITE'] . "</td><td>" . $resp['NOM'] . " " . $resp['PRENOM'] . "</td>" .
                            "<td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                            . " onclick = \"deleteResponsabilite('" . $resp['IDRESPONSABLEELEVE'] . "');\"  /></td></tr>";
                        }
                        ?></tbody>
                </table>
            </div>
        </fieldset>
        <form name="formresponsable"  action='' method="post" enctype="multipart/form-data">
            <fieldset style="width: 480px; height: 446px;"><legend>Informations li&eacute;es au responsable</legend>
                <span class="select" style="width: 50px">
                    <label>Civilit&eacute;</label>
                    <?php echo $civilite; ?>
                </span>
                <span class="text" style="width: 170px">
                    <label>Nom</label>
                    <input type="text" name="nom" />
                </span>
                <span class="text" style="width: 200px">
                    <label>Pr&eacute;nom</label>
                    <input type="text" name="prenom" />
                </span>
                <span class="select" style="width: 120px; clear: both">
                    <label>Parent&eacute;</label>
                    <?php echo $parente; ?>
                </span>
                <span class="text" style="width: 315px" >
                    <label>Profession</label>
                    <input type="text" name="profession" />
                </span>
                <div style="height: 10px; clear: both; content: ' ';"></div>
                <?php
                foreach ($charges as $charge) {
                    echo "<span style = 'margin-right:15px'>"
                    . "<input type ='checkbox' value = \"" . $charge['IDCHARGE'] . "\" name = 'charge' />";
                    echo "<label style = 'font-weight:bold;'>" . $charge['LIBELLE'] . "</label></span>";
                }
                ?>
                <span class="text" style="width: 140px">
                    <label>Portable</label>
                    <input type="text" name="portable" />
                </span>
                <span class="text" style="width: 140px">
                    <label>T&eacute;l&eacute;phone</label>
                    <input type="text" name="telephone" />
                </span>
                <span class="text" style="width: 140px">
                    <label>E-mail</label>
                    <input type="text" name="email" />
                </span>
                <span  style="width: 200px; display: block; float: left; position: relative; top: 20px;">
                    <input type="checkbox" name="acceptesms" checked ='checked' />
                    Accepte l'envoi de SMS

                </span>
                <span class="text" style="width: 140px;" >
                    <label>N° envoi de SMS</label>
                    <input type="text" name="numsms" maxlength="20"/>
                </span>

                <fieldset style="width: 440px;"><legend>Coordonn&eacute;es</legend>

                    <span class="text" style="width: 418px;">
                        <label>Adresse</label>
                        <input type="text" name="adresse1" placeholder = 'Adresse'/>
                    </span>
                    <span class="text" style="width: 418px;margin-top:-10px;" placeholder = 'Adresse'>
                        <input type="text" name="adresse2" placeholder = 'Adresse'/>
                    </span>
                    <span class="text" style="width: 418px; margin-top:-10px;">
                        <input type="text" name="adresse3" placeholder = 'Adresse' />
                    </span>
                    <span class="text" style="width: 418px;">
                        <label>Boite Postale</label>
                        <input type="text" name="bp" />
                    </span>

                </fieldset>
                <div  style="position: relative; top: 10px; margin-right: 10px; clear: both;" class="navigation">
                    <?php echo btn_ok("saveResponsable()"); ?>
                    <?php echo btn_cancel("resetResponsable();") ?>
                </div>
            </fieldset>
        </form>

        </fieldset>
    </div>
    <div id="onglet3" class="onglet" style=" display: none; height: 470px; ">
        <form action="<?php echo Router::url("eleve", "photo", "upload"); ?>"  enctype="multipart/form-data" id="frmphoto">
            <fieldset style = 'width: 400px; height: 270px;'><legend>Photo d'identit&eacute;</legend>
                <p>Vous pouvez si vous le souhaitez, ajouter une photo d'identit&eacute; sur 
                    la fiche de l'&eacute;l&egrave;ve.
                </p>
                <p>Cette photo est visible sur les &eacute;cran uniquement pour le personnel 
                    de l'&eacute;tablissement et permet l'impression
                </p>
                <p>Vous devez utilisez imp&eacute;rativement un format de photo d'identit&eacute; 
                    r&eacute;glementaire de 200x200 px sous peine d'obtenir une photo d&eacute;form&eacute;e.
                </p>
                <p>
                    Les formats gif, jpg, jpeg et png sont accept&eacute;s.
                </p>
                <input type="file" name="photo" maxlength="30" required="" style="margin: 0; padding: 0" />
                <div  style="position: relative; top: 10px; margin-right: 10px; clear: both;" class="navigation">
                    <div id="btn_photo_action"><?php 
                    if (!empty($eleve['PHOTO']) && file_exists(ROOT . DS . "public" . DS . "photos" . DS . "eleves" . DS . $eleve['PHOTO'])){
                        echo btn_add_disabled()." ".btn_effacer("effacerPhotoEleve()");
                    }else{
                        echo btn_add("savePhotoEleve()")." ".btn_effacer_disabled("");
                    }
                    ?>
                    </div>
                </div>
            </fieldset>

            <div id="photoeleve" style="border: 1px solid #000; float: left;  position: relative;width: 200px; height: 200px;margin: 8px 20px;">
                <?php
                if (isset($eleve['PHOTO']) && !empty($eleve['PHOTO'])) {
                    echo "<img style = 'width:200px;height:200px;' src = '" . SITE_ROOT . "public/photos/eleves/" . $eleve['PHOTO'] . "' />";
                }
                ?>
            </div>
        </form>
    </div>
</div>
<div class="recapitulatif">
    <div class="errors">
<?php
//if ($errors)
//  echo $message;
?>
    </div>
</div>
<div class="navigation">
<?php echo btn_ok("soumettreFormEleve();"); ?>
</div>

<div class="status"></div>
