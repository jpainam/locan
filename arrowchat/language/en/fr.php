<?php

	/*
	|| #################################################################### ||
	|| #                             ArrowChat                            # ||
	|| # ---------------------------------------------------------------- # ||
	|| #     Copyright 2010-2012 ArrowSuites LLC. All Rights Reserved.    # ||
	|| # This file may not be redistributed in whole or significant part. # ||
	|| # ---------------- ARROWCHAT IS NOT FREE SOFTWARE ---------------- # ||
	|| #   http://www.arrowchat.com | http://www.arrowchat.com/license/   # ||
	|| #                                                                  # ||
    || #         Version 1.8 Française écrite par Yannick Raval           # ||
	|| #                   Email : yann@yannanderson.com                  # ||
	|| #                                                                  # ||
	|| #################################################################### ||
	*/

	$language = array();

	// ########################### STATUS #############################
	$language[1]			=	"Disponible";								// Available users
	$language[2]			=	"Occupé";										// Busy users
	$language[3]			=	"Invisible";								// Invisible users
	$status['available']	=	"Je suis disponible";							// Default available status message
	$status['busy']			=	"Je suis occupé";									// Default busy status message
	$status['away']			=	"Je suis absent";									// Default idle status message
	$status['offline']		=	"Je suis hors-ligne";								// Default offline status message
	$status['invisible']	=	"Je suis hors-ligne";								// Default invisible status message
	$language[83]			=	"Invité";									// Displayed if the user has no username

	// ####################### SERVICE UPDATES ########################
	$language[27]			=	"Le Chat est actuellement en cours de maitenance";  // Hover message when chat is in maintenance mode
	$language[28]			=	"Fermer"; 									// Close the announcement message
	$language[58]			=	"Vous devez vous enregistrer ou vous connecter pour utiliser le Chat";	// The message that guests view when logged out

	// ######################## NOTIFICATIONS #########################
	$language[0]			=	"Notifications"; 							// Displayed in the title bar of the notifications popup
	$language[9]   			=   "Vous n'avez pas de nouvelles notifications"; 			// Displayed when a user has no new notifications
	$language[21]			=	"Voir toutes les notifications"; 					// The tooltip to see all notifications
	$language[71]			=	"seconde";								// Displayed after the time in notifications (second)
	$language[72]			=	"secondes";								// Displayed after the time in notifications (seconds)
	$language[73]			=	"minute";								// Displayed after the time in notifications (minute)
	$language[74]			=	"minutes";								// Displayed after the time in notifications (minutes)
	$language[75]			=	"heure";									// Displayed after the time in notifications (hour)
	$language[76]			=	"heures";								// Displayed after the time in notifications (hours)
	$language[77]			=	"jour";									// Displayed after the time in notifications (day)
	$language[78]			=	"jours";									// Displayed after the time in notifications (days)
	$language[79]			=	"mois";								// Displayed after the time in notifications (month)
	$language[80]			=	"mois";								// Displayed after the time in notifications (months)
	$language[81]			=	"année";									// Displayed after the time in notifications (year)
	$language[82]			=	"années";								// Displayed after the time in notifications (years)
	$language[144]			=	"Nouveau message de ";						// DISPLAYS USERNAME AFTER - The title for HTML5 notifications

	// ######################### BUDDY LIST ###########################
	$language[4]			=	"Chat"; 									// Displayed in the title bar of the buddy list popup
	$language[7]			=	"Membres hors-ligne"; 							// Displayed in the buddy list tab when offline
	$language[8]    		=   "Personne n'est disponible pour chatter"; 			// Displayed with no one is online
	$language[12]   		=   "Rechercher des ami(e)s en ligne"; 									// Displayed in the search text area of the buddy list
	$language[22]			=	"Statut";									// Button to show status options in the buddy list
	$language[23]			=	"Options";									// Button to show options in the buddy list
	$language[25]			=	"Chargement...";											// Text to show while the buddy list is loading (Must remove CSS background image too)
	$language[26]			=	"Aucun membre trouvé";						// Displayed when no friends are found after searching	
	$language[119]			=	"Entrez un nom pour chatter";				// Displayed in the guest username box
	$language[120]			=	"Vous devez entrer un nom";					// Error message when the user enters no guest name
	$language[121]			=	"Le nom ne peut contenir que des chiffres et des lettres";	// Error message when the user enters a guest name with more than letter/numbers
	$language[122]			=	"Il y a un mot interdit dans votre nom: ";	// DISPLAYS BLOCKED WORD AFTER - Error message when the user enters a blocked word guest name
	$language[123]			=	"Vous ne pouvez pas changer de nom encore une fois";		// Error message when user trys to change guest name again
	$language[124]			=	"Ce nom existe déjà";				// Error message when duplicate guest name is selected
	$language[125]			=	"Le nom ne peut pas dépasser 25 caractères";// Error message when guest name is too long
	$language[140]			=	"Se connecter à Facebook";						// Text to connect to Facebook
	$language[141]			=	"Se déconnecter de Facebook";						// Text to logout from Facebook
	$language[142]			=	"Utilisateurs sur le site";								// Text to display for site user's group
	$language[143]			=	"Ami(e)s Facebook";							// Text to display for facebook friend's group

	// ########################### OPTIONS ############################
	$language[5]			=	"Disponible";						// Option to go offline text
	$language[6]			=	"Jouer un son lors d'un nouveau message";								// Option to play sound for new messages text
	$language[17]   		=   "Garder la fenêtre ouverte";							// Option to keep the buddy list open text
	$language[18]   		=   "N'afficher que les noms dans la liste";							// Option to hide avatars in the buddy list text
	$language[29]			=	"Thème: ";									// Text to display next to the theme change select box
	$language[95]			=	"Gérer les personnes bloquées...";						// Option to manage the block list
	$language[96]			=	"Sélectionnez l'utilisateur à débloqer";		// Text to display when a user is managing the block list
	$language[97]			=	"Débloquer";									// Text to display on unblock button
	$language[108]			=	"Sélectionnez le thème à utiliser";			// Text to display when a user is choosing a theme
	$language[109]			=	"Choisir";									// Text to display on the choose theme button
	$language[118]			=	"Sélectionner";									// Text to display on the selection for the block menu

	// ######################## APPLICATIONS ##########################
	$language[16]  		 	=   "Applications";								// Displayed in the title bar of the applications popup
	$language[20]			=	"Favoris";								// Displayed in the applications popup for the user's bookmarked applications
	$language[64]			=	"Autres applications";						// Displayed under bookmarks (non-bookmarks heading)
	$language[65]			=	"Déplacez pour organiser";							// Drag to reorder text
	$language[104]			=	"Garder l'application ouverte";							// Displayed in the menu to keep an app window open
	$language[105]			=	"Toujours charger cette application";							// Displayed in the menu to load the app when the bar loads

	// ######################### HIDE CHAT ############################
	$language[14]   		=   "Masquer le Chat";								// Displayed when the user hovers over the hide chat button
	$language[15]   		=   "Afficher le Chat";								// Displayed when the user hovers over the show chat button

	// ######################## POPOUT CHAT ############################
	$language[10]   		=   "Pop-Out";								// Option to pop out chat
	$language[11]   		=   "Pop-In";								// Option to pop in chat

	// ############################ CHAT ###############################
	$language[13]  	 		=   "Cet utilisateur n'est plus en ligne. Il recevra votre message lors de sa prochaine connexion";		// DISPLAYS USERNAME FIRST - Shown when a message is sent to an offline user
	$language[24]			=	"Effacer l'historique";													// Displayed in the chat popup to clear chat history
	$language[30]			=	"Nouveau message de";														// DISPLAYS USERNAME AFTER - Blinks in the title of the browser on new messages
	$language[59]			=	"Plus &#9660;";															// The text to display more chat options
	$language[60]			=	"Pop-Out";															// The pop out chat option in the more menu
	$language[61]			=	"Vous avez reçu une invitation pour utiliser le Vidéo Chat. Ignorez ce message pour annuler";// The message to send when a video chat is reuqested
	$language[62]			=	"Accepter";																// Accept a video chat request
	$language[63]			=	"Votre demande pour le video Chat a été envoyée";								// Displayed when a user sends a video chat request
	$language[66]			=	"Transfert de fichiers...";															// The file transfer option in the more menu
	$language[67]			=	"Annuler";													// The link to cancel the file transfer
	$language[68]			=	"Votre fichier à été uploadé et envoyé";								// Displayed when a user sends a file
	$language[69]			=	"Vous avez reçu un fichier. Ignorez ce message pour annuler";															// The message to send when a file is sent
	$language[70]			=	"Télécharger le fichier";														// Download a file that was sent
	$language[84]			=	"Bloquer l'utilisateur";															// Blocks a user
	$language[85]			=	"Voulez-vous aussi dénoncer cet utilisateur ?";								// Asks the user if they want to report another user
	$language[86]			=	"Parcourir";																// The text to browse for a file when uploading
	$language[87]			=	"Cliquer sur 'Parcourir' pour envoyer un fichier ou ";										// Text to display when uploading a file
	$language[88]			=	"Démarrer le Vidéo Chat";													// Displays when mouseover the video chat icon
	$language[89]			=	"Fermer le Chat";															// Displays when mouserver the close icon
	$language[90]			=	"Vous";																	// Displays on mosueover of your own chat text
	$language[102]			=	"Le message n'a pas pu être envoyé car cet utilisateur vous a bloqué";						// Displays this when a user tries to send a message to another user who has them blocked
	$language[103]			=	"Cet utilisateur a été bloqué. Vous ne recevrez plus ses messages"; // Displays when a user is blocked
	$language[134]			=	"Défillez vers le bas pour voir les nouveaux messages";										// Displays when a chat window is not scrolled down on a new message
	$language[135]			=	"Il y a eu une erreur durant l'envoie de votre message. Veuillez ré-essayer plus tard";			// Error message when a message fails to send
	$language[146]			=	"Le Vidéo Chat est momentannément indisponible";								// Displays when mouseover the video chat icon and user is offline
	$language[151]			=	"Il y a eu une erreur durant l'envoi de votre fichier. Veuillez essayer plus tard";								// File upload error message

	// ######################### CHAT ROOMS #############################
	$language[19]			=	"Chambres";								// Displayed in the chatrooms popup and tab
	$language[31]			=	"Créer";									// Button to show create chatroom
	$language[32]			=	"Options";									// Button to show chatroom options
	$language[33]			=	"Quitter";									// Button to show leave chatroom
	$language[34]			=	"Chargement...";											// Text so show while the chatroom list is loading (Must remove CSS background image too)
	$language[35]			=	" en ligne";									// DISPLAYS ONLINE COUNT FIRST - Shown after online count in list
	$language[37]			=	"Créer une nouvelle chambre:";					// Text to display in the create chatroom popup
	$language[36]   		=   "Toujours ouvrir la fenêtre";							// Option to keep the chatroom window open
	$language[47]			=	"Toujours fermer la fenêtre";								// Option to stay in the chatroom without the window open on page load
	$language[38]			=	"Bloquer les discussions privées";						// Option to block private chats from users in the chatroom
	$language[39]			=	"Vous devez attendre un peu avant d'ouvrir une nouvelle chambre";	// Error to show when the chatroom flood limit is reached
	$language[40]			=	"Les chambres sont désactivées";				// Error to show when user chatrooms are disabled
	$language[41]			=	"Message privé";							// Send user a private messages
	$language[42]			=	"Voir le profil";							// Visit the user's profile
	$language[43]			=	"Invité";									// The user's title in the chatroom - shown when the user is a guest
	$language[44]			=	"Moderateur";								// The user's title in the chatroom - shown when the user is a moderator
	$language[45]			=	"Administrateur";							// The user's title in the chatroom - shown when the user is an administrator
	$language[46]			= 	"Cet utilisateur a désactivé ses messages privés"; // The text that the alert box will display when a user trys to PM with blocked chat
	$language[48]			=	"Cette chambre n'existe pas";			// Displayed when a user trys to enter an invalid chatroom
	$language[49]			=	"Le mot de passe est incorrect";		// Displayed when a user enters the wrong password
	$language[50]			=	"Entrez le mot de passe pour cette chambre";						// Text to display when entering the chatroom password
	$language[51]			=	"Limite atteinte. Veuillez patienter un peu";	// Error to show when flood limit is reached
	$language[52]			=	"Donner le statut de Modérateur";							// Make the user a moderator
	$language[54]			=	"Supprimer le statut de Modérateur";							// Remove the user from being a moderator
	$language[53]			=	"Expulser cet utilisateur";								// Ban/Kick the user from the chatroom
	$language[55]			=	"Vous avez été expulsé de cette chambre";					// Shown when a user is permanently banned
	$language[56]			=	"Vous avez été expuslé de cette chambre pour quelques minutes: ";		// DISPLAYS MINUTES AFTER - shown when a user is kicked
	$language[57]			=	"Combien de minutes voulez-vous expulser l'utilisateur? (0 = permanent)";	// Message to show when banning a user.  Typing 0 will permanently ban the user
	$language[91]			=	"Entrez le nom de la chambre que vous voulez créer";		// Message to display when creating a chat room
	$language[92]			=	"Quitter le chambre";							// Tooltip when mousover the leave chat room icon
	$language[93]			=	"Créer une nouvelle chambre";					// Tooltip when mouseover the create chat room icon
	$language[94]			=	"Changer le thème du Chat";					// Tooltip when mouseover the change theme icon
	$language[98]			=	"Nom";										// Placeholder for the create chatroom name box
	$language[99]			=	"Mot-de-passe (optionnel)";						// Placeholder for the create chatroom password box
	$language[100]			=	"Rejoindre";										// Displayed on UI buttons to join a chat room
	$language[101]			=	"Jouer un son lors d'un nouveau message dans cette chambre";							// The option to enable/disable chat room sounds
	$language[106]			=	" a été nommé modérateur par ";			// DISPLAYS USERNAME FIRST/MODERATOR AFTER - Shown after a user is made a moderator
	$language[107]			=	" a été expulsé de la chambre par ";	// DISPLAYS USERNAME FIRST/MODERATOR AFTER - Shown after a user is kicked
	$language[117]			=	"Pop-Out";							// Option to pop out the chat room
	$language[127]			=	"Il y a trop d'utilisateurs dans cette chambre. Veuillez ré-essayer plus tard";	// Displayed when a user tries to enter a chat room with too many online.
	$language[136]			=	" (Admin)";									// Will display after a username when an administrator
	$language[137]			=	" (Mod)";									// Will display after a username when a moderator
	$language[147]			=	"Utilisateurs";									// Text to display for chat room's user group
	$language[148]			=	"Admins";									// Text to display for chat room's admin group
	$language[149]			=	"Mods";										// Text to display for chat room's mod group
	$language[150]			=	"Pas de description";					// Text for chat rooms that have no description entered
	$language[152]			=	"Toujours afficher les noms";						// Option to always show names in a chat room
	$language[153]			=	"Editer le message de bienvenue...";					// Option to edit the welcome message
	$language[154]			=	"Entrez le message de bienvenue que vous souhaitez afficher quand les utilisateurs entrent dans cette chambre. Entrez une valeur vide si vous ne souhaitez rien afficher";	// Prompt for the mod/admin to edit the welcome message
	$language[155]			=	"Les paramètres ont bien été sauvegardé";	// Notice when an admin or mod saves settings
	$language[156]			=	" a reçu le statut de modérateur par ";	// DISPLAYS USERNAME FIRST/MODERATOR AFTER - Shown after a user is made a moderator
	$language[157]			=	"Editer la déscription...";						// Option to edit the description
	$language[158]			=	"Entrez la déscription que vous voulez afficher dans la liste de la chambre";	// Prompt for the mod/admin to edit the description
	$language[159]			=	"Message supprimé par ";						// DISPLAYS USERNAME AFTER - Shown when a chat room message is deleted in replacement of the message
	$language[160]			=	"Supprimer le message";							// Tooltip to show on the delete message icon
	$language[161]			=	"Rendre l'utilisateur silencieux";								// Option to silence a user
	$language[162]			=	"Entrez le nombre de secondes durant lesquelles l'utilisateur sera silencieux. La durée maximale est de 300 secondes";	// Message to show when silencing a user
	$language[163]			=	" a été rendu silencieux par ";					// DISPLAYS USERNAME FIRST/MODERATOR AFTER - Shown after a user is silenced
	$language[164]			=	"Vous avez été rendu silencieux pour ";			// DISPLAYS SECONDS AFTER - The first half of the user is silenced error message.
	$language[165]			=	" secondes";								// DISPLAYS SECONDS BEFORE - The second half of the user is silenced error message.
	$language[169]			=	"Limite atteinte. Veuillez patienter encore ";	// DISPLAYS SECONDS AFTER - The first half of the flood message
	$language[170]			=	" secondes avant de chatter";					// DISPLAYS SECONDS BEFORE - The second half of the flood message
	$language[171]			=	"Editer la limite du débit de messages...";						//	Option to change the chat room flood limits
	$language[172]			=	"Sélectionnez les paramètres de la limite du débit de messages";			// Text to display in the flood menu
	$language[173]			=	"Sauvegarder";										// Button text for the flood menu save
	$language[174]			=	"message(s) chaque";							// In between the flood message and time
	$language[175]			=	"seconde(s)";								// After the flood time
	
	// ########################## MODERATORS #############################
	$language[166]			=	"Moderation";								// Displayed in the moderators popup and tab
	$language[167]			=	"Report Spam/Abuse";						// Option in 1-on-1 chat settings to report a person
	$language[168]			=	"Thank you for your report.";				// Message after a report is filed
	$language[177]			=	"Report From";								// Header for the reports from column
	$language[178]			=	"Report About";								// Header for the reports about column
	$language[179]			=	"Report Time";								// Header for the reports time column
	$language[180]			=	"Total Reports";							// DISPLAYS # OF REPORTS FIRST - Used in the title to show total number of reports
	$language[181]			=	"Reports On User";							// The header for the reports list
	$language[182]			=	"Someone else is already working on this report.";	// Error message when a report is already being worked on
	$language[183]			=	"Ban User";									// Option to ban the user
	$language[184]			=	"Warn User";								// Option to warn the user
	$language[185]			=	"Close Report";								// Option to close the report
	$language[186]			=	"Back to Lobby";							// Option to go back to the reports list
	$language[187]			=	"Report #";									// DISPLAYS REPORT NUMBER AFTER - shown in the reports on user list
	$language[188]			=	"No additional reports";				 	// Displays when no other reports are available
	$language[189]			=	"There are no reports, hooray!";			// Displays in the lobby when there are no reports
	$language[190]			=	"About: ";									// DISPLAYS ABOUT USER AFTER - The pretext for the user the report is about
	$language[191]			=	"From: ";									// DISPLAYS FROM USER AFTER - The pretext for the user the report is from
	$language[192]			=	"Previous Warnings: ";						// DISPLAYS WARNINGS AFTER - The pretext for the number of previous warnings
	$language[193]			=	"Time: ";									// DISPLAYS TIME AFTER - The pretext for the time of the report
	$language[194]			=	"The user was reported here";				// Displays in the report history where the user was reported
	$language[195]			=	"Are you sure you want to PERMANENTLY ban this user?  The user will have to be unbanned from the ArrowChat admin panel.";	// Prompt when the ban user option is clicked
	$language[196]			=	"Enter a reason for the warning.  THIS WILL BE SHOWN TO THE WARNED USER.";	// Prompt when after to enter a warning reason
	$language[197]			=	"This user has been warned in the past 24 hours.  Are you sure you want to warn again?";	// Prompt when the user has been warning in the past 24 hours
	$language[198]			=	"I Understand";								// The text that closes a warning notification
	$language[199]			=	"You have been warned by a moderator. Continued spam or abuse of the chat system could lead to a permanent ban. The reason that the moderator has given for the warning is below:";	
	
	// ######################### MOBILE CHAT #############################
	$language[110]			=	"Messenger";			// Displays in the header of the mobile chat
	$language[111]			=	"Membres connectés";			// Displays in the header for the online user list
	$language[112]			=	"Membres hors-ligne";			// Displays in the header for the idle user list
	$language[113]			=	"Retour";					// Displays on the back button when viewing a chat
	$language[114]			=	"Envoyer";					// Text for the send button
	$language[115]			=	"Nouveau";					// Text to display when a new message is received
	$language[116]			=	"Vous devez vous connecter pour utiliser le Chat Mobile";	// Text to display when user is not logged in using mobile
	$language[126]			=	"Retour";					// Displays as a button to return to the website when in mobile chat
	$language[128]			=	"Chambres";			// Displays in the header for the chat room list
	$language[129]			=	"Paramètres";				// Displays in the header for the settings
	$language[130]			=	"Afficher la liste des chambres";	// The option to show chat rooms
	$language[131]			=	"Afficher la liste des membres hors-ligne";	// The option to show idle users
	$language[132]			=	"On";					// The on option for a toggle
	$language[133]			=	"Off";					// The off option for a toggle
	$language[138]			=	"Entrez le mot de passe de la chambre:";	// Text to display for the chat room password input
	$language[139]			=	"Entrer dans la chambre";		// The submit button to enter a chat room
	$language[145]			=	"Chat Mobile";			// The text to appear on mobile chat tab
	$language[176]			=	"Chat Récent";			// Displays in the header for the recent chat list

?>