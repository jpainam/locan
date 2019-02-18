<div id="entete">
<div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_email.png"; ?>" /></div>
</div>
<div class="titre">Modification de mon email</div>

<form action="<?php echo Router::url("user", "email"); ?>" method="post" >
    <div class="page">
        <fieldset style="margin: auto; width: 350px; position: relative;float: none;"><legend>Changement de l'Email</legend>
            <span class="text" style="width: 300px">
                <label>Nouvel E-mail</label><input required type="email" name="email" />
            </span>

        </fieldset>
    </div>
    <div class="recapitulatif"><div class="errors"><blink>
        <?php
        if($errors)
            echo $message;
        ?>
            </blink>
        </div></div>
    <div class="navigation">
        <?php echo btn_ok("document.forms[0].submit();"); ?>
        <?php echo btn_cancel("document.location=\"" . Router::url("user", "fiche") . "\""); ?>
    </div>
</form>
<div class="status"></div>