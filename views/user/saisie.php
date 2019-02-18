<div id="entete">
<div class="logo"><img src="<?php echo SITE_ROOT."public/img/wide_user.png"; ?>" /></div>
</div>
<div class="titre">
    Saisie d'un nouvel utilisateur du syst&eacute;me
</div>
<form name="frmuser" method="post" action="<?php echo Router::url("user", "saisie"); ?>" >
    <div class="page">
        <fieldset style="float: none !important; width: 65%; height: 20%; margin: auto;">
            <legend>Information de l'utilisateur</legend>
            <span class="text" style="width: 250px"><label>Login</label>
                <input type="text" name="login" required="required" />
            </span>
            <span class="text" style="width: 250px"><label>Mot de passe</label>
                <input type="password" name="pwd" required="required" />
            </span>
            <span class="select" style="width: 253px"><label>Profile</label>
                <?php echo $comboProfiles; ?>
            </span>
            <span class="select" style="width: 253px"><label>Personnel</label>
                <?php echo $comboPersonnels; ?>
            </span>
        </fieldset>
    </div>
    <div class="recapitulatif">
        <div class="errors">
            <?php if($errors){
                echo "L'utilisateur ".$user." existe d&eacute;j&agrave; dans le syst&eacute;me";
            } ?>
        </div>
    </div>
    <div class="navigation">
        <?php
        if (isAuth(607)) {
            echo btn_ok("ajouterUser()");
        }
        ?>
    </div>
</form>
<div class="status">
    
</div>