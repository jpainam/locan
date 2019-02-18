<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
         <link type="text/css" rel="stylesheet" id="arrowchat_css" media="all" 
              href="<?php echo SITE_ROOT ?>arrowchat/external.php?type=css" charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestion des activités académique</title>
        <link href = "<?php echo SITE_ROOT; ?>public/img/favicon.ico" rel = "shortcut icon" type = "image/vnd.microsoft.icon" />
        <link href = "<?php echo SITE_ROOT; ?>public/css/style.css" rel = 'stylesheet' type = 'text/css' />
        
        <?php
        # <link href = "<?php echo SITE_ROOT; public/css/jquery.datetimepicker.css" rel = 'stylesheet' type = 'text/css' />
        global $css;
        if (!empty($css)) {
        echo $css;
        }
        # <script type="text/javascript" src="<?php echo SITE_ROOT; public/js/jquery.datetimepicker.js"></script>
        ?><script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/scripts.js"></script>
        <?php echo $clientsjs; ?>
        <?php
        global $_JS;
        if (!empty($_JS)) {
            echo "<script>$_JS</script>";
        }
        ?>
        <script>
            $(document).ready(function () {
                if ($(".status").length !== 0) {
<?php
if (isset($_SESSION['user']) && isset($_SESSION['anneeacademique'])) {

    echo '$(".status").html("Utilisateur connect&eacute; : ' . $_SESSION['user'] . "    IPW / ANNEE ACADEMIQUE : " . $_SESSION['anneeacademique'] . '");';
}
?>
                }
            });
</script>
      </head>
    <body>
        <div id="container">
           <?php
            echo $header;
            if ($authentified) {
                echo '<div id = "page-content">' . $content . '</div>';
            } else {
                echo '<div id = "page-connect">' . $content . "</div>";
            }
            ?>

            <div id="page-footer">
                <?php echo $footer; ?>
            </div>
            <div id="loading"><p>
                    <img src="<?php echo SITE_ROOT . "public/img/loading.gif" ?>" />
                </p>
            </div>
        </div>
        <!-- Inclure late loading fichier JS -->
          <script type="text/javascript" src="<?php echo SITE_ROOT ?>arrowchat/external.php?type=djs" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT ?>arrowchat/external.php?type=js" charset="utf-8"></script>
    </body>
</html>
<?php
/*
 *  <!-- tous les includes doivent se passer dans le controller
        Correspondant et l'obtenir sous la forme d'une variable data[];
         Pour le cas du template, c'est le controller de base
            -->
 */