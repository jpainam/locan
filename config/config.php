<?php
/**
	Environnement de developpement
	Remettre cela a false lors du deploiement
	Si definie a false, aucune erreur ne sera lever ou afficher,
	les erreurs seront enregistrer dans le fichier temp/log.txt
*/
define('DEVELOPMENT_ENVIRONMENT', true);

/**
	definir l'adresse du site
	Definir par exemple
	define('SITE_ROOT', 'http://192.168.1.103') si le serveur est distant
*/
//define('SITE_ROOT', 'http://192.168.1.3/ipw/');
define('SITE_ROOT', 'http://localhost/locan/');
define('DEFAULT_CONTROLLER', "index");
define('DEFAULT_ACTION', "index");

/* Nom de la base de donnees*/
define("DB_NAME", 'ipw');
/* Non d'utilisateur de la base de donnee*/
define("DB_USER", 'root');
/* Mot de passe de la base de donnees*/
define("DB_PASSWORD", "");
/* Adresse du server hebergeant la base de donnees*/
define("DB_HOST", 'localhost');

