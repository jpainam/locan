<style>  
    .page span{
        display: inline-block;

        margin-bottom: 0;
    }

    .recu_img{
        position: absolute;
        opacity: 0.1;
        width: 350px;
        height: 300px;
        left: 29%;
        top: 10%;

    } 
    .recu_libelle{
        font-family: "CAC Champagne";
        font-size: 30px;

    }


</style>
<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_caisse.png"; ?>" /></div>
</div>
<div class="titre">
</div>

<div class="page">
    <fieldset style="float: none !important; width: 90%; height: 70%; margin: auto;background-color: #FFF;">
        <legend>Re&ccedil;u de caisse</legend>
        <img style="float: left; height: 100px; width: 100px;" src="<?php echo SITE_ROOT . "public/img/" . LOGO; ?>" />
        <img class="recu_img" src="<?php echo SITE_ROOT . "public/img/" . LOGO; ?>" />

        <div style="text-align: center; font-weight: bold;">
            INSTITUT POLYVALENT WAGUE<br/>
            BP : 5062, Yaound&eacute; / CAMEROUN<br/>
            T&eacute;l : (+237) 697 86 84 99<br/>
            *************
            <span style="float: right;width: 180px; display: inline-block;font-size: 18px;margin: 0; padding: 0;
                  ">Classe : <?php echo $classe['NIVEAUHTML']; ?>
            </span>
        </div>

        <p style="clear: right;float: right;width: 180px;font-weight: bold">
            <span style="background-color: #D3D3D3;padding: 10px;display: inline-block;width: 90%;border: 1px solid #800000;">
                Montant : #<?php echo moneyString($operation['MONTANT']); ?>#</span>
            <?php
            $d = new DateFR($operation['DATETRANSACTION']);

            echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime();
            $restant = $montantapayer['TOTALFRAIS'] - $montantpayer['MONTANTPAYER'];
            ?></p>
        <h2 style="text-align: center; font-size: 20px;">
            <font style="text-decoration: underline">REF:</font> <?php echo $operation['REFCAISSE']; ?>
        
        <?php if(!empty($operation['BORDEREAUBANQUE'])){
            echo "<br/><small><b style='text-decoration: underline'>N° Bordereau Banque:</b> ".$operation['BORDEREAUBANQUE']."</small><br/>";
        }
        ?>
            </h2>
        <div style="clear: both; position: relative; top: -5px; font-size: 18px">
            <span style="width: 80px; text-align: left">Re&ccedil;u de </span> : <?php echo $operation['NOMEL'] . "  " . $operation['PRENOMEL']; ?><br/>
            <span style="width: 80px; text-align: left">Pour  </span> : 
            <span class="recu_libelle" ><?php echo $operation['DESCRIPTION']; ?></span><br/>
            <span style="width: 80px;text-align: left">MONTANT</span> : <?php echo moneyString($operation['MONTANT']); ?> <em>fcfa</em>
            <span style="font-size: 14px"><i>(<?php echo enLettre($operation['MONTANT']); ?> franc cfa)</i></span><br/>
                
                <span style="width: 80px;text-align: left">RESTE</span> : <?php echo moneyString($restant); ?> <em>fcfa</em>
                <span style="font-size: 14px"><i>(<?php echo enLettre($restant); ?> franc cfa)</i></span><br/>
        </div>
        <div style="text-align: left !important;">
            <span style="display: inline-block; float: left; width: 250px;top: 10px; position: relative;">S/C <?php
                echo $operation['CIVILITEREP'] . " " . $operation['NOMREP'] . " "
                . $operation['PRENOMREP'];
                ?><br/>
                T&eacute;l : <?php echo $operation['PORTABLEREP']; ?>
                <br/><br/>
                Imprim&eacute; par 
                <?php
                echo $imprimeur['CIVILITE'] . " " . $imprimeur['NOM'] . " " . $imprimeur['PRENOM'] .
                " le ";
                if (empty($operation['IMPRIMERPAR'])) {
                    $d->setSource(date("Y-m-d H:i:s", time()));
                } else {
                    $d->setSource($operation['DATEIMPRESSION']);
                }
                echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime();
                ?>
            </span>
            <span style="display: inline-block ;top:25px ;position:relative">
                <?php echo $barcode; ?>
            </span>
            <span style="display: inline-block; width: 250px; float: right;top: 10px; position: relative;"> Enreg. par 
                <?php echo $enregistreur['CIVILITE'] . " " . $enregistreur['NOM']; ?><br/>
                <br/><br/>
                Per&ccedil;u par <?php echo $enregistreur['CIVILITE'] . " " . $percepteur['NOM']; ?><br/>
                <span style="text-align: right"><?php
                    if(isset($operation['DATEPERCEPTION'])){
                        $d->setSource($operation['DATEPERCEPTION']);
                        echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime();
                    }
                    ?>
                </span>
            </span>
        </div>

    </fieldset>
</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <?php
    if (empty($operation['IMPRIMERPAR'])) {
        if (isAuth(522)) {
            echo "En cochant cette case, vous certifiez avoir recu ce montant en votre nom : "
            . "<input style=\"vertical-align: middle;\" type=\"checkbox\" name=\"certifier\" />";
            echo btn_print("imprimerRecu(" . $operation['IDCAISSE'] . ")");
        }
    }
    if(!empty($operation['IMPRIMERPAR']) && !$estDirectrice){
        echo "Ce re&ccedil;u a d&eacute;j&agrave; &eacute;t&eacute; imprim&eacute; par " . $imprimeur['NOM'];
    }
    if (!empty($operation['IMPRIMERPAR']) && $estDirectrice) {
          echo "Ce re&ccedil;u a d&eacute;j&agrave; &eacute;t&eacute; imprim&eacute; par " . $imprimeur['NOM'];
          
        echo "<input style=\"vertical-align: middle;\" checked='checked' disabled type=\"checkbox\" name=\"certifier\" />";
        echo btn_print("imprimerRecu(" . $operation['IDCAISSE'] . ")");
    }
    ?>
</div>
<div class="status"></div>