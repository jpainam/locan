<?php if ($authentified) { ?>
    <div id = "page-header">
        <!-- h1>ENTETE DU SITE CONTENANT NOS DEUX LOGO</h1 -->
        <a href="<?php echo Router::url(); ?>" style="border: none;padding: 0; margin: 0;">
            <img  height="180" width="200" src="<?php echo SITE_ROOT . "public/img/" . LOGO ?>"  /></a>
        <div id = "menu">

            <div id="content-menu">
                <?php echo $menu; ?>
            </div>
            <?php /* < a href = "<?php echo SITE_ROOT; ?>">Home</a> | 
              <a href = "<?php echo SITE_ROOT; ?>about">A Propos</a> |
              <a href = "<?php echo SITE_ROOT; ?>eleve">Eleve</a> |
              <a href = "<?php echo SITE_ROOT; ?>matiere">Matiere</a> |
              <a href = "<?php echo SITE_ROOT; ?>note">Note</a> |
              <a href = "<?php echo SITE_ROOT; ?>personnel">Personnel</a> |
              <a href = "<?php echo SITE_ROOT; ?>connexion/disconnect">Deconnexion</a>
             */
            ?>
        </div>
    </div>
    <?php
}
        