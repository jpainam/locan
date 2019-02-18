<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
</div>
<div class="titre">
    Ajout d'un nouvel &eacute;l&egrave;ve
</div>

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
        <form action="<?php echo url('eleve', 'saisie'); ?>" name = 'frmeleve' method="post" enctype="multipart/form-data">
            <fieldset style="clear: both; width: 800px"><legend>Identité</legend>
                <input type="hidden" name="ideleve" value="" />
                <input type='hidden' name='responsable' value=""/>
                <input type="hidden" name="photoeleve" value="" />

                <span class="text" style="width: 250px">
                    <label>Nom <i style="color: red" class="exist-eleve"></i></label>
                    <datalist id="listeeleve">
                        <?php
                            foreach ($eleves as $ele){
                                echo "<option value='".$ele['NOM']."'>";
                             }
                        ?>
                    </datalist>
                    <input type="text" list="listeeleve" name="nomel" maxlength="30" onblur="verificationDoublons();" />
                </span>
                <span class="text" style="width: 228px">
                    <label>Prénom <i style="color: red" class="exist-eleve"></i></label>
                    <datalist id="listeeleveprenom">
                        <?php
                            foreach ($eleves as $ele){
                                echo "<option value='".$ele['PRENOM']."'>";
                             }
                        ?>
                    </datalist>
                    <input type="text" list="listeeleveprenom" name="prenomel" maxlength="30" onblur="verificationDoublons();" />
                </span>
                <span class="text" style="width: 228px">
                    <label>Autre Nom</label>
                    <input type="text" name="autrenom" maxlength="30" />
                </span>
                <span class="select" style="width: 255px;margin-right: 10px; clear: both;">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </span>
                <span class="select" style="width: 234px; margin-right: 7px;">
                    <label>Pays de nationalité</label>
                    <?php echo $nationalite; ?> 
                </span>
                <span class="text" style="width: 228px; margin-left: 0;"><label>Lieu de r&eacute;sidence : 
                        <input type="text" name="residence" />
                </span>
            </fieldset>
            <div style="height: 30px; clear: both; content: ' ';"></div>
            <fieldset style="width: 370px">
                <legend>Date et lieu de naissance</legend>
                <span class="text" style="width: 140px">
                    <label>Date de Naissance</label>
                    <!-- div id="datenaiss" style="margin-top: 10px;"></div -->
                    <input type="text" id="datenaiss" name="datenaiss" placeholder="Date Naissance" />
                </span>
                <span class="select" style="width: 190px; margin-left: 10px;">
                    <label>Pays de Naiss.</label>
                    <?php echo $paysnaiss; ?>
                </span>
                <span class="text" style="width: 350px">
                    <label>Lieu de Naissance</label>
                    <input type="text" name="lieunaiss" maxlength="30" />
                </span>
            </fieldset>
            <fieldset style="width: 419px;  float: right;">
                <legend>Informations internes</legend>
                <span class="text" style="width: 150px;margin-right: 22px;">
                    <label>CNI</label>
                    <input type="text" name="cni" />
                </span>
                <span class="text" style="width: 222px;" >
                    <label>Identifiant dans l'Etabl.: Matricule</label>
                    <input type="text" name="matricule" value="" placeholder="Laisser vide si inconnu"/>
                </span>
                <span class="text" style="width: 150px;margin-right: 20px;">
                    <label>Date entrée : </label>
                    <!-- div id="dateentree" style="margin-top: 10px;"></div -->
                    <input type="text" id="dateentree" name="dateentree" maxlength="30" />
                </span>
                <span class="select" style="width: 230px">
                    <label>Provenance :</label>
                    <select name="provenance" id="provenance" style="width: 100%">
                        <?php echo $provenance; ?>
                    </select>
                </span>
                <span class="select" style="width: 155px">
                    <label>Redoublant</label>
                    <select name="redoublant">
                        <option value="0" selected="selected">Non</option>
                        <option value="1">Oui</option>
                    </select>
                </span>
                <span class="select" style="width: 230px">
                    <label>Classes</label>
                    <!-- input type="text" name="classe" disabled="disabled" value="R.A.S" / -->
                    <?php echo $classes; ?>
                </span>
                <span class="text" style="width: 150px;margin-right: 20px;">
                    <label>Date de sortie : </label>
                    <!-- div id="date" style="margin-top: 10px;"></div -->
                    <input type="text" id="datesortie" name="datesortie" maxlength="30" />
                </span>
                <span class="text" style="width: 222px">
                    <label>Motif de sortie : </label>
                    <input type="text" name="motifsortie" disabled="disabled" value="R.A.S" />
                </span>
            </fieldset>
            <fieldset style="width: 370px; height: 70px;"><legend>Fr&egrave;res et s&oelig;urs</legend>
                <span class="text" style="width: 350px">
                    <label>Noms des fr&egrave;res et s&oelig;urs inscrits &agrave; IPW</label>
                    <input type="text" name="frereetsoeur" />
                </span>
            </fieldset>
            <input type="hidden" value="" name="duplicate_validator" />
        </form>
    </div>
    <div id="onglet2" class="onglet" style="display: none; height: 470px;">

        <fieldset style = 'height:446px;width: 300px;'><legend>Responsables</legend>

            <p style="margin: 0 0 5px 0; text-align: right">
                <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" id="ajout-responsable" style="cursor: pointer;" />
            </p>
            <div id="ajout-responsable-dialog-form"  class="dialog"  title="Selectionner un responsable"><span>
                    <label>Choisir un responsable</label>
                    <?php echo $comboResponsables; ?></span>
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
                    <tbody id="responsablebody"></tbody>
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
                    <div id="btn_photo_action"><?php echo btn_add("savePhotoEleve()"); ?>
                        <?php echo btn_effacer_disabled(""); ?>
                    </div>

                </div>
            </fieldset>

            <div id="photoeleve" style="border: 1px solid #000; float: left;  position: relative;width: 200px; height: 200px;margin: 8px 20px;">

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
<?php
/**
 * Les dialog pour la saisie d'un nouvel etablissement
 */
?>
<div id="preciser-libelle-dialog-form" class="dialog" title="Pr&eacute;ciser le nom de l'&eacute;tablissement">
    <span><label>Nom de l'&eacute;tablissement</label>
        <input style="width: 100%" type="text" name="preciserets" /></span>
</div>
