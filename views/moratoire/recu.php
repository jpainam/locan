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
        font-size: 20px;

    }


</style>
<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_caisse.png"; ?>" /></div>
</div>
<div class="titre">
</div>

<div class="page">
    <fieldset style="float: none !important; width: 90%; height: 70%; margin: auto;background-color: #FFF;">
        <legend>Re&ccedil;u de moratoire</legend>
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
                Montant du Moratoire : #<?php echo moneyString($operation['MONTANT']); ?>#</span>
            <?php
            $d = new DateFR($operation['DATEOPERATION']);

            echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . " " . $d->getTime();
            ?></p>
        <h2 style="text-align: center; font-size: 20px;">
            <font style="text-decoration: underline">MORATOIRE<br/></font> <?php echo $operation['REFMORATOIRE']; ?>
            </h2>
        <div style="clear: both; position: relative; top: -5px; font-size: 18px">
            <span style="width: 100px; text-align: left">Moratoire accord&eacute; &agrave;: </span> : <?php echo $operation['NOMEL'] . "  " . $operation['PRENOMEL']; ?><br/>
            <span style="width: 100px; text-align: left">Description:  </span> : 
            <span class="recu_libelle" ><?php echo $operation['DESCRIPTION']; ?></span><br/>
            <span style="width: 80px;text-align: left">MONTANT</span> : <?php echo moneyString($operation['MONTANT']); ?> <em>fcfa</em>
            <span style="font-size: 14px"><i>(<?php echo enLettre($operation['MONTANT']); ?> franc cfa)</i></span><br/>
                
                <span style="width: 80px;text-align: left">ECHEANCE</span> : <?php echo date('d-M-y', strtotime($operation['ECHEANCE'])); ?> <em>fcfa</em>
          <br/>
        </div>
        <div style="text-align: left !important;">
            <span style="display: inline-block; float: left; width: 250px;top: 10px; position: relative;">S/C <?php
                echo $operation['CIVILITEREP'] . " " . $operation['NOMREP'] . " "
                . $operation['PRENOMREP'];
                ?><br/>
                T&eacute;l : <?php echo $operation['PORTABLEREP']; ?>
                <br/>
            </span>
          
            <span style="display: inline-block; width: 250px; float: right;top: 10px; position: relative;"> Enreg. par 
                <?php echo $enregistreur['CIVILITE'] . " " . $enregistreur['NOM']; ?><br/>
                <br/>
            </span>
        </div>

    </fieldset>
</div>
<div class="recapitulatif">

</div>
<div class="navigation">
    <?php
    if (isAuth(539)) {
        echo "Imprimer ce moratoire : ";
        echo btn_print("imprimerMoratoire(" . $operation['IDMORATOIRE'] . ")");
    }
    ?>
</div>
<div class="status"></div>