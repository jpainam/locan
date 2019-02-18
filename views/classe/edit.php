<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_classe.png"; ?>" /></div></div>
<div class="titre">Modification de la classe</div>
<form action="<?php echo Router::url('classe', 'edit', $idclasse); ?>" method="post" enctype="multipart/form-data" name="frmclasse">
    <div class="page">
        <fieldset style="margin: auto;margin-bottom: 5px; float: none; width: 750px;"><legend>Saisie de la classe</legend>
            <span class="select" style="width: 150px;"><label>Nom abr&eacute;g&eacute;</label>
                <?php echo $comboNiveau ?></span>
            <span class="text" style="width: 360px;"><label>Libell&eacute;</label><input type="text" name="libelle" value="<?php echo $libelle; ?>"/></span>
            <span class="select" style="width: 150px;">    
                <label>D&eacute;coupage</label>
                <?php echo $comboDecoupage; ?>
            </span>
            <input type="hidden" name="idclasse" value="<?php echo $idclasse ?>" />
            <input type="hidden" name="identifiant" value="" />
            <input type="hidden" name="matiere" value="" />
        </fieldset>
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 2);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        El&egrave;ves
                    </a>
                </li>
                <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 2);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Mati&egrave;res
                    </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;">
            <fieldset style="width: 45%; height: 415px;"><legend>Elèves</legend>
                <?php //echo $comboEleves; ?>
                <img id="ajout_eleve" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin: 3px; cursor: pointer;  float: right;">
                <div id="dialog-1" class="dialog" title="Selectionner un Eleve">
                    <span>
                        <label>Choisir Un Eleve</label>
                        <?php echo $comboElevesNonInscrits; ?>
                    </span>
                </div>
                <div id="eleve_content">
                    <table class="dataTable" id="tab_elv">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody>      <?php
                            foreach ($elevesInscrits as $eleve) {
                                echo "<tr><td>" . $eleve['MATRICULE'] . "</td><td>" . $eleve['CNOM'] . "</td>"
                                . "   <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                                . " onclick = \"desinscrire('" . $eleve['IDINSCRIPTION'] . "');\"  /></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table></div>
            </fieldset>

            <fieldset style="width: 45%; height: 128px; margin-left: 10px; "><legend>Prof. Principal</legend>
                <?php
                if (!empty($prof)) {
                    echo "<img id='ajout_pp' src='" . SITE_ROOT . "public/img/btn_add_disabled.png' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                } else {
                    echo "<img id='ajout_pp' src='" . SITE_ROOT . "public/img/btn_add.png.' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                }
                ?>
                <div id="dialog-2" class="dialog" title="Selectionner un Enseignant">
                    <span><label>Choisir Un Enseignant</label><?php echo $comboEnseignants; ?></span>
                </div>
                <div id="prof_content">
                    <table class="dataTable" id="tab_pp">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody><?php
                            if (!empty($prof)) {
                                echo "<tr><td>" . $prof['MATRICULE'] . "</td><td>" . $prof['CNOM'] . "</td>" .
                                " <td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                                . " onclick = \"deletePrincipale(1);\"  /></td></tr>";
                            }
                            ?></tbody>
                    </table></div>
            </fieldset>
            <fieldset style="width: 45%; height: 128px;  margin-left: 10px;"><legend>Cpe. Principal</legend>
                <?php
                if (!empty($cpe)) {
                    echo "<img id='ajout_cpe' src='" . SITE_ROOT . "public/img/btn_add_disabled.png' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                } else {
                    echo "<img id='ajout_cpe' src='" . SITE_ROOT . "public/img/btn_add.png.' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                }
                ?>
                <div id="dialog-3" class="dialog" title="Selectionner un Parent Principal">
                    <span><label>Choisir Un Parent</label><?php echo $comboResponsables; ?></span>
                </div>
                <div id="cpe_content">
                    <table class="dataTable" id="tab_cpe">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody>
                            <?php
                            if (!empty($cpe)) {
                                echo "<tr><td>" . $cpe['CIVILITE'] . "</td><td>" . $cpe['NOM'] . " " . $cpe['PRENOM'] . "</td>" .
                                "<td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                                . " onclick = \"deletePrincipale(2);\"  /></td></tr>";
                            }
                            ?> </tbody>
                    </table></div>
            </fieldset>
            <fieldset style="width: 45%; height: 128px; margin-left: 10px;"><legend>Responsable Administratif</legend>
                <?php
                if (!empty($admin)) {
                    echo "<img id='ajout_ra' src='" . SITE_ROOT . "public/img/btn_add_disabled.png' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                } else {
                    echo "<img id='ajout_ra' src='" . SITE_ROOT . "public/img/btn_add.png.' style='position: relative; margin: 3px;; cursor: pointer;  float: right;'>";
                }
                ?>
                <div id="dialog-4" class="dialog" title="Selectionner Un Resp. Administratif">
                    <span>
                        <label>Choisir Un Resp. Administratif</label>
                        <?php echo $comboEnseignants; ?>
                    </span>
                </div>
                <div id="admin_content">
                    <table class="dataTable" id="tab_ra">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody><?php
                            if (!empty($admin)) {
                                echo "<tr><td>" . $admin['MATRICULE'] . "</td><td>" . $admin['NOM'] . " " . $admin['PRENOM'] . "</td>" .
                                "<td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                                . " onclick = \"deletePrincipale(3);\"  /></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table></div>
            </fieldset>
        </div>
        <div id="onglet2" class="onglet" style="display: none; height: 75%">
            <img id="ajout_mat" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin: 3px; cursor: pointer;  float: right;">
            <div id="dialog-5" class="dialog" title="Ajout d&apos;une Mati&egrave;re">
                <span><label>Mati&egrave;re</label><?php echo $comboMatieres; ?></span>
                <span><label>Enseignant</label><?php echo $comboEnseignants; ?></span>
                <span style="display: inline-block; width: 82%">
                    <label>Groupe</label><?php echo $comboGroupe; ?>
                </span>
                <span style="display: inline-block; width: 10%">
                    <label>Ordre</label>
                    <select name="ordre">
                        <?php
                        for ($i = 1; $i <= 40; $i++) {
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                        ?>
                    </select>
                </span>
                <span><label>Coeff.</label>
                    <input id="spinner" name="spin" size ="5" value="2"/>
                </span>

            </div>
            <div id="matiere_content">
                <table class="dataTable" id="tab_mat">
                    <thead><tr><th>Ordre</th><th>Mati&egrave;re</th><th>Enseignants</th><th>Groupe</th><th>Coeff.</th><th></th></tr></thead>
                    <tbody><?php
                        foreach ($enseignements as $ens) {
                            echo "<tr><td>" . $ens['ORDRE'] . "</td><td>"
                            . "<input type='hidden' value='" . $ens['IDMATIERE'] . "'/>" . $ens['CODE'] . " - " . $ens['MATIERELIBELLE'] . "</td><td>" . $ens['NOM'] . " " . $ens['PRENOM'] . "</td>"
                            . "<td><input type='hidden' value='" . $ens['GROUPE'] . "' />" . $ens['DESCRIPTION'] . "</td>"
                            . "<td>" . $ens['COEFF'] . "</td><td align = 'center'><img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/edit.png'"
                            . " onclick = \"editEnseignement('" . $ens['IDENSEIGNEMENT'] . "', this);\"  />&nbsp;&nbsp;";
                            if (isAuth(533)) {
                                echo "<img style = 'cursor:pointer' src = '" . SITE_ROOT . "public/img/delete.png'"
                                . " onclick = \"deleteEnseignement('" . $ens['IDENSEIGNEMENT'] . "');\"  />";
                            } else {
                                echo "<img src='".img_delete_disabled()."' style='cursor:pointer' />";
                            }
                            echo "</td></tr>";
                        }
                            ?></tbody>
                    </table>
                </div>
                <div id="dialog-6" class="dialog" title="Modification Mati&egrave;re" style="display:none;">
                    <span>
                        <label>Mati&egrave;re</label>
                        <select id="matiere" name="matiereedit" style="width: 100%; ">
                            <?php
                            foreach ($matieres as $mat) {
                                echo "<option value='" . $mat['IDMATIERE'] . "'>" . $mat['LIBELLE'] . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                    <span>
                        <label>Enseignant</label>
                        <?php echo $comboEnseignants2; ?>
                    </span>
                    <span style="display: inline-block; width: 82%">
                        <label>Groupe</label>
                        <?php echo $comboGroupe2; ?>
                    </span>
                    <span style="display: inline-block; width: 10%">
                        <label>Ordre</label>
                        <select name="ordre1">
                            <?php
                            for ($i = 1; $i <= 40; $i++) {
                                echo "<option value='" . $i . "'>" . $i . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                    <span>
                        <label>Coeff.</label>
                        <input id="spinner1" name="spin" size ="5" value="2"/>
                    </span>
                </div>
            </div>
        </div>
        <div class="recapitulatif">
            <?php
            if ($errors) {
                echo $message;
            }
            ?>
        </div>
        <div class="navigation">
            <img  src="<?php echo SITE_ROOT . "public/img/btn_ok.png" ?> " onclick="document.forms[0].submit();" />
            <img  src="<?php echo SITE_ROOT . "public/img/btn_cancel.png" ?> " 
                  onclick="document.location = '<?php echo Router::url("classe"); ?>'" />
    </div>
</form>
<div class="status"></div>