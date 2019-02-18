<div id="entete">
    <div class="logo"> <img src="<?php echo SITE_ROOT . "public/img/wide_user.png" ?>" /></div>
    <div style="margin-left: 150px;">
        <span class="select" style="width: 200px">
            <label>Utilisateurs</label>     
            <?php echo $comboUser; ?>
        </span>
    </div>
</div>
<form action="<?php echo Router::url("user", "droit"); ?>" method="post" name="frmdroit" >
    <div class="page">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 3);"><img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Informations utilisateur
                    </a>
                </li>
                <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 3);"><img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Droits utilisateurs
                    </a>
                </li>
                <li id="tab3" class="noncourant">
                    <a onclick="onglets(1, 3, 3);"><img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/eleve.png"; ?>" />
                        Ses Connexions
                    </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;height: 90%">
            <fieldset  style="width: 680px;float: none; margin: auto;"><legend>Profile utilisateur</legend>
                <table cellpadding = "3">
                    <tr><td style="font-weight: bold;width :200px">Login : </td><td><?php //echo $login; ?></td></tr>
                    <tr><td style="font-weight: bold">Mot de passe : </td><td><?php //echo "xxxxxxxxxxxxxxxxxxxxxxx"; ?></td></tr>
                    <tr><td style="font-weight: bold">Profile : </td><td><?php //echo $profile; ?></td></tr>
                    <tr><td style="font-weight: bold">Actif : </td><td><?php //echo $actif; ?></td></tr>
                </table>
            </fieldset>
            <div style="height: 20px; content: ' ';"></div>
            <fieldset style="width: 680px;float: none; margin: auto;"><legend>Information du personnel</legend>
                <table cellpadding = "3">
                    <tr><td  style="font-weight: bold; width :200px">ID Personnel : </td><td><?php //echo $idpersonnel; ?></td></tr>
                    <tr><td style="font-weight: bold">Civilit&eacute; : </td><td><?php //echo $civilite; ?></td></tr>
                    <tr><td style="font-weight: bold">Nom : </td><td><?php //echo $nom; ?></td></tr>
                    <tr><td style="font-weight: bold">Pr&eacute;nom : </td><td><?php //echo $prenom; ?></td></tr>
                    <tr><td style="font-weight: bold">Autre nom : </td><td><?php //echo $autrenom; ?></td></tr>
                    <tr><td style="font-weight: bold">Fonction : </td><td><?php //echo $fonction; ?></td></tr>
                    <tr><td style="font-weight: bold">Grade : </td><td><?php //echo $grade; ?></td></tr>
                    <tr><td style="font-weight: bold">Date naissance : </td><td><?php //echo $datenaiss; ?></td></tr>
                    <tr><td style="font-weight: bold">Portable : </td><td><?php //echo $portable; ?></td></tr>
                    <tr><td style="font-weight: bold">T&eacute;l&eacute;phone : </td><td><?php //echo $telephone; ?></td></tr>
                    <tr><td style="font-weight: bold">Email : </td><td><?php //echo $email; ?></td></tr>
                </table>
            </fieldset>
        </div>
        <div id="onglet2" class="onglet" style="display: none; height: 90%"><?php echo $droits; ?></div>
        <div id="onglet3" class="onglet" style="display: none; height: 90%"><?php echo $connexions; ?></div>
    </div>
    <div class="navigation">
        <?php echo btn_ok("validerFormDroit();"); ?>
    </div>
</form>
<div class="status"></div>