# LOCAN

## PROCEDURE D'INSTALLATION DU PROGRAMME INTRANET LOCAN			

### Decompresser le fichier locan.zip
### Installer les programmes 
	wampserver2.2d-x64.exe; wampserver2.2d-x32.exe ou xampplite-win32-1.7.3.exe dans le repertoire outils.
	selon votre configuration, installer soit le 32bits ou le 64bits de wamp ou xampplite.
	Le repertoire d'installation doit etre c:\wamp ou c:\xampplite

### NB. NE PAS OUBLIER D'ACTIVER LE MODULE REWRITE "mod_rewrite" DE APACHE. 
	Si vous ne connaissez pas comment le faire, google est un bon ami.
	
### Copier le dossier locan decompressé sous le repertoire 
	c:\wamp\www pour wamp ou c:\xampplite\htdocs pour xampplite.
	Le chemin d'accès doit etre c:\wamp\www\locan ou c:\xampplite\htdocs\locan
	Verifier que les sous dossiers se trouvent immediatement sous la radicale locan et non c:\wamp\www\locan\locan

### Executer (start WampServer/Xamp Control panel) 
	le programme wamp ou xampplite installé.
	-l'icone de notification doit etre vert pour wamp et marqué "serveur en ligne"
	-Pour les utilisateurs de xampplite, cliquer sur start Apache et Start MySQL. ils doivent marquer running
	-Sinon redemarrer la machine et arreter skype

### Cliquer sur l'icon de notification pour wamp et selectionner phpMyAdmin. 
	pour les utilisateur xampplite cliquer sur le button admin de MySQL.
	-Une page web s'ouvre.  Pour xampplite, dans le menu de gauche cliquer sur phpMyAdmin
	-Cliquer sur l'onglet Base de données/database.
	-Entrer le nom de la base de donnéee : ipw et cliquer sur creer/create
	-Choisir locan sur le menu de gauche pour les utilisateurs de wamp. pour les utilisateurs de xampplite, passer à l'étape suivante.
	-cliquer sur l'onglet importer/import.
	-Cliquer sur browse/parcourir et selectionner le fichier .sql situer c:\wamp\www\locan\ipw.sql ou c:\xampplite\htdocs\locan\ipw.sql
	-Cliquer sur go/valider

### Compte administrateur:
	-Nom utilisateur/login : admin
	-Mot de passe: 19881
### Acceder au logiciel en lancant un navigateur et saisir localhost/locan sur la barre d'addresse.
	-Lancer wampServer chaque fois qu'il faut lancer le logiciel.
	
### POUR LES UTILISATEURS AVANCES ET ATTENTION A CETTE MANIPULATION
	-definisser un mot de passe au SGBD.
	-Editer le fichier c:\wamp\www\locan\config\config.php
	-Si vous avez installe le serveur sur une machine distante, entrer l'adresse de la machine distante à la place de localhost.
