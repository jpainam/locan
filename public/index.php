<?php
ini_set("max_execution_time", 600);
header('Content-Type: text/html; charset=utf-8');

function my_session_start() {
    $sn = session_name();
    if (isset($_COOKIE[$sn])) {
        $sessid = $_COOKIE[$sn];
    } else if (isset($_GET[$sn])) {
        $sessid = $_GET[$sn];
    } else {
        return session_start();
    }

    if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $sessid)) {
        return false;
    }
    return session_start();
}

if (!my_session_start()) {
    session_id(uniqid());
    session_start();
    session_regenerate_id();
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('TIME_OUT', 3600);
# Nombre d'horaire pour les appels, 9 pour les 1ere et Terminale
define("MAX_HORAIRE", 7);

if (!defined("CAL_GREGORIAN")) {
    define("CAL_GREGORIAN", 0);
}
/**
 * Utiliser dans les fonctions getDateIntervale du controller principale
 */
define("PERIODE_MENSUELLE", 1);
define("PERIODE_SEQUENCE", 2);
define("PERIODE_TRIMESTRE", 3);
define("PERIODE_ANNEEACADEMIQUE", 4);

define('FIRST_TITLE', 47);
define("Y_PDF", 47);
define("X_PDF", 10);
define("PDF_Y", 47);
define("PDF_X", 10);

define('PDF_MIDDLE', 110);

define("DIRECTOR_PROFILE", 6);
define("ADMIN_ID", 1);
define("PA_FRANC_ID", 5);

define("BACKUP_PATH", "backups");

define("NUM_CONCEPTEUR", "+237698106057");


define("BARCODE_1", 1);

define("ETS_ORIGINE", 1);

# Premiere annee d'installation du logiciel dans l'etablissement
define("FIRST_ACADEMIQUE_YEAR", "2015-2016");

# Nombre de colonne pour l'appel des enseignants
define("HEURE_TRAVAIL", 8);

define("MAIN_ETABLISSEMENT", "IPW");

define("LOGO", "ipw.png");

define("PAYS_CAMEROUN", 36);

$url = isset($_GET['url']) ? $_GET['url'] : null;
$bas_bulletin = array();

$css = "";
$_JS = "";
require_once(ROOT . DS . 'library' . DS . 'Bootstrap.php');
