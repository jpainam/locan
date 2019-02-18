<?php
if(isset($deja)){
    echo "Appel r&eacute;alis&eacute; et certifi&eacute; par  ".$auteur = "";
}else{ ?>
    En cochant cette case, vous certifiez l'exactitude des donn&eacute;es saisies 
        en votre nom : <input style="vertical-align: middle;" type="checkbox" name="certifier" />
            <?php echo btn_save_appel("soumettreAppel();"); ?>
<?php }