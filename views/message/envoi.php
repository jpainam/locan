<div id="entete">

</div>
<form action="<?php echo Router::url("message", "envoi"); ?>" method="post" name="frmenvoi">
    <div class="page">
        <div class="tabs" style="width: 100%">
            <ul>
                <li id="tab1" class="courant">
                    <a onclick="onglets(1, 1, 3);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/individuel.png"; ?>" />
                        Message individuel
                    </a>
                </li>
                 <li id="tab2" class="noncourant">
                    <a onclick="onglets(1, 2, 3);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/envoiparclasse.png"; ?>" />
                        Messages par classe
                    </a>
                </li>
                <li id="tab3" class="noncourant">
                    <a onclick="onglets(1, 3, 3);">
                        <img border ="0" alt="" src="<?php echo SITE_ROOT . "public/img/icons/collectif.png"; ?>" />
                        Message collectif
                    </a>
                </li>
            </ul>
        </div>
        <div id="onglet1" class="onglet" style="display: block;height: 90%">
            <fieldset style="float: none !important; width: 65%; margin: auto; height: 60%">
                <legend>Zone de saisie de message</legend>
                <span class="text" style="width: 80%"><label>Destinataire : </label>
                    <input type="text" name="destinataire" list="listDestinataire" />
                    <datalist id="listDestinataire">
                        <?php
                        foreach ($destinataires as $d) {
                            echo "<option value='" . $d['PORTABLE'] . "'>" . $d['NOM'] . "</option>";
                        }
                        ?>
                    </datalist>
                </span>
                <span class="text" style="width: 79%; clear: both; height: 90%"><label>Message : </label>
                    <textarea name="message" rows="10" cols="3" ></textarea></span>
            </fieldset>
            <p style="text-align: right; margin-right: 150px">
                <?php echo btn_ok("envoyerSMS();");  ?>
            </p>
        </div>
        <div id="onglet2" class="onglet" style="display: none; height: 90%">
            <fieldset style="float: none !important; width: 65%; margin: auto; height: 60%">
                <legend>Zone de saisie de message</legend>
                <span class="text" style="width: 80%"><label>Destinataire : </label>
                    <?php echo $comboParclasse; ?>
                </span>
                <span class="text" style="width: 79%; clear: both; height: 90%"><label>Message : </label>
                    <textarea name="messageparclasse" rows="10" cols="3" ></textarea></span>
            </fieldset>
            <p style="text-align: right; margin-right: 150px">
                <?php echo btn_ok("envoyerParclasse();");  ?>
            </p>
        </div>
        <div id="onglet3" class="onglet" style="display: none;height: 90%">
             <fieldset style="float: none !important; width: 65%; margin: auto; height: 60%">
                <legend>Zone de saisie de message</legend>
                <span class="text" style="width: 80%"><label>Destinataire : </label>
                    <select name="collectif">
                        <option value=""></option>
                        <option value="1">Parents d'&eacute;l&egrave;ves</option>
                        <option value="2">Enseignants de l'Institut</option>
                        <option value="3">Staff permanent de l'Institut</option>
                    </select>
                </span>
                <span class="text" style="width: 79%; clear: both; height: 90%"><label>Message : </label>
                    <textarea name="messagecollectif" rows="10" cols="3" ></textarea></span>
            </fieldset>
            <p style="text-align: right; margin-right: 150px">
                <?php echo btn_ok("envoyerCollectif();");  ?>
            </p>
        </div>
    </div>
    <div class="recapitulatif"></div>
    <div class="navigation">
        <?php
        //echo btn_ok("envoyerSMS();");
        ?>
    </div>
</form>
<div class="status">
    <?php if (isset($errors)) { ?>
        <script>
            $(document).ready(function () {
    <?php
    if ($errors) {
        echo "alertWebix('Message non envoy&eacute; <br/>Une erreur s\'est prouite');";
    } else {
        echo "alertWebix('Message envoy&eacute; avec succ&egrave;s');";
    }
    ?>
            });
        </script>
    <?php }
    ?>
</div>