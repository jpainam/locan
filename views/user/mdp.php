<div id="entete">
     <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_pwd.png"; ?>" /></div>
</div>
<div class="titre">Changement de son mot de passe</div>

<form name ="frmcontent" action="<?php echo Router::url("user", "mdp"); ?>" method="post" >
    <div class="page">
        <fieldset style="margin: auto; width: 450px; position: relative;float: none;"><legend>Changement de mot de passe</legend>
            <span class="text" style="width: 200px" >
                <label>Mot de passe actuel</label><input type="password" name="pwdactuel" />
            </span>
            <span class="text" style="width: 200px">
                <label>Nouveau mot de passe</label><input type="password" name="newpwd"  />
            </span>
            <span class="text" style="width: 200px;">
                <label>Confirmation du mot de passe</label><input type="password" name="confpwd" />
            </span>
        </fieldset>
        <div class="errors">
            En cas de succ&egrave;s, Vous serez redigir&eacute; sur la page d'authentification <br/>....<br/>
            Utilisez votre nouveau mot de passe pour vous r&eacute;-authentifier
        </div>
    </div>
    <div class="recapitulatif"><div class="errors"><blink>
            <?php
            if ($errors) {
                echo $message;
            }
            ?>
            </blink>
        </div>
    </div>
    <div class="navigation">
        <?php echo btn_ok("document.forms['frmcontent'].submit();"); ?>
        <?php echo btn_cancel("document.location='" . Router::url() . "'"); ?>
    </div>
</form>
<div class="status"></div>
