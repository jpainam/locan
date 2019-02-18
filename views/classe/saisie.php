<div id="entete"><div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_classe.png"; ?>" /></div></div>
<div class="titre">Saisie des classes</div>
<form action="<?php echo url('classe', 'saisie'); ?>" method="post" enctype="multipart/form-data" name="frmclasse">
    <div class="page" style="">
        <fieldset style="margin:auto; width: 710px;margin-bottom: 10px;float: none;"><legend>Saisie de la classe</legend>
            <span class="select" style="width: 150px;"><label>Nom abr&eacute;g&eacute;</label>
                <?php echo $comboNiveau ?></span>

            <span class="text" style="width: 360px;"><label>Libellé</label><input type="text" name="libelle" /></span>
            <span class="select" style="width: 150px;">    
                <label>Découpage</label>
                <select name="decoupage">
                    <option value="1">S&eacute;quence</option>
                    <option value="2">Trimestre</option>
                    <option value ="2">Semestre</option>
                </select>
            </span>
            <input type="hidden" name="idclasse" value="" />
            <input type="hidden" name="identifiant" value="" />
            <input type="hidden" name="matiere" value="" />
        </fieldset>


        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 2);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Elèves
                    </a>
                </li>
                <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 2);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Matières
                    </a>
                </li>
            </ul>
        </div>

        <div id="onglet1" class="onglet" style="display: block;float: none; margin: auto;">
            <fieldset style="width: 360px; height: 415px;"><legend>Elèves</legend>
                <?php //echo $comboEleves; ?>
                <img id="ajout_eleve" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin-bottom: 3px; cursor: pointer;  float: right;">
                <div id="dialog-1" class="dialog" title="S&eacute;lectionner un Eleve">
                    <span>
                        <label>Choisir Un Eleve</label>
                        <?php echo $comboEleves; ?>
                    </span>
                </div>
                <div id = "eleve_content">
                    <table class="dataTable" id="tab_elv">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </fieldset>

            <fieldset style="width: 360px; height: 128px; margin-left: 10px; "><legend>Prof. Principal</legend>
                <img id="ajout_pp" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin-top: 3px; margin-bottom: 15px; cursor: pointer;  float: right;">
                <div id="dialog-2" class="dialog" title="Selectionner un Enseignant">
                    <span>
                        <label>Choisir Un Enseignant</label>
                        <?php echo $comboEnseignants; ?>
                    </span>
                </div>
                <div id = "prof_content">
                    <table class="dataTable" id="tab_pp">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </fieldset>
            <fieldset style="width: 360px; height: 128px;  margin-left: 10px;"><legend>Cpe. Principal</legend>
                <img id="ajout_cpe" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin-top: 3px; margin-bottom: 15px; cursor: pointer;  float: right;">
                <div id="dialog-3" class="dialog" title="Selectionner un Parent Principal">
                    <span>
                        <label>Choisir Un Parent</label>
                        <?php echo $comboResponsables; ?>
                    </span>
                </div>
                <div id="cpe_content">
                    <table class="dataTable" id="tab_cpe">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </fieldset>
            <fieldset style="width: 360px; height: 128px; margin-left: 10px;"><legend>Responsable Administratif</legend>

                <img id="ajout_ra" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin-top: 3px; margin-bottom: 15px; cursor: pointer;  float: right;">
                <div id="dialog-4" class="dialog" title="Selectionner Un Resp. Administratif">
                    <span>
                        <label>Choisir Un Resp. Administratif</label>
                        <?php echo $comboEnseignants; ?>
                    </span>

                </div>
                <div id="admin_content">
                    <table class="dataTable" id="tab_ra">
                        <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </fieldset>

        </div>
        <div id="onglet2" class="onglet" style="display: none; height: 420px;">
            <img id="ajout_mat" src="<?php echo SITE_ROOT . "public/img/btn_add.png"; ?>" style="position: relative; margin-top: 3px; margin-bottom: 15px; cursor: pointer;  float: right;">
            <div id="dialog-5" class="dialog" title="Ajout d&apos;une Mati&egrave;re">

                <span>
                    <label>Mati&egrave;re</label>
                    <?php echo $comboMatieres; ?>
                </span>
                <span>
                    <label>Enseignant</label>
                    <?php echo $comboEnseignants; ?>
                </span>
                <span>
                    <label>Groupe</label>
                    <?php echo $comboGroupe; ?>
                </span>
                <span>
                    <label>Coeff.</label>
                    <input id="spinner" name="spin" size ="5" value="2"/>
                </span>

            </div>
            <div id="matiere_content">
            <table class="dataTable" id="tab_mat">
                <thead><tr><th>Matière</th><th>Enseignants</th><th>Groupe</th><th>Coefficient</th><th></th></tr></thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="recapitulatif" >
        <?php
        if ($errors) {
            echo "<div class = 'errors'>" . $message . "</div>";
        }
        ?>
    </div>
    <div class="navigation">
        <?php
        echo btn_ok("soumettreFormClasse();");
        ?>
        
        &nbsp;&nbsp;&nbsp;&nbsp;
        <img  src="<?php echo SITE_ROOT . "public/img/btn_cancel.png" ?> " 
              onclick="annulerSaisieClasse();" />
    </div>

</form>
<div class="status"></div>