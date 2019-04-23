<div align="center" style="margin:auto;">
    <div id="submenu" style="text-shadow:1px 1px 2px #808040; font-variant:small-caps;font-weight:bold;border-top-style:solid;">
        Portail De Connexion.   
    </div>
</div>
<div id="content" style="margin-top:20px;">
    <form action ="<?php echo Router::url('connexion'); ?>" method="post">     			
        <div class="contenu">
            <p class="titleconnexion">Institut Polyvalent WAGUE</p>
            <p class="trait"></p>
            <div>
                <table border="0" cellspacing="5" style="margin:auto;">
                    <tr>
                        <td>
                            <label class="txt" title="Nom Utilisateur ou matricule">Nom Utilisateur :</label>
                        </td>
                        <td>
                            <input type="text" maxlength="100" size="30" name="login" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="txt">Mot de Passe  :</label>
                        </td>
                        <td>
                            <input type="password" maxlength="100" size="30" name="pwd"  accesskey="enter"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="txt" title="Ann&eacute;e Acad&eacute;mique">Ann&eacute;e Scol. : </label></td>
                        <td>
                            <?php echo $anneeacademique; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if ($errors) {
                                echo "<div id=\"erreur\">Erreur de connexion<br/>"
                                . "Verifier votre mot de passe ou utilisateur</div>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" id="but" value="Connexion" accesskey="enter"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>

