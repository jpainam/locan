<?php
# Permet de changer les mots de passe quelque soit l'utilisateur
# UTile quand l'utilisation a oubliee sont mdp
?>
<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_pwd.png"; ?>" />
    </div>
</div>
<div class="titre">Modifier les mots de passe utilisateurs</div>
<form action="<?php echo Router::url("parametre", "mdp"); ?>" method="post" name="frmPwd">
    <div class="page">
        <fieldset style="margin: auto; float: none !important; width: 50%"><legend>Modifier le mot de passe d'un utilisateur</legend>
            <span class="select" style="width: 305px">
                <label>Utilisateur</label>
                <?php echo $comboUtilisateurs; ?>
            </span>
            <span class="text" style="clear: both; width: 300px">
                <label>Nouveau mot de passe</label>
                <input type="password" required="required" name="pwd" />
            </span>
            
        </fieldset>
    </div>
    <div class="navigation">
        <?php
        if(isAuth(602)){
            echo btn_ok("changerPwd()");
        }
        ?>
    </div>
</form>

<div class="status"></div>