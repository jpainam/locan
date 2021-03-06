<?php

	/*
	 *	Bloons
	 *	Designed By: ArrowChat Team
	 *	Support: support@arrowchat.com
	 *	Date: 2/17/2010
	 *	
	 *	This file is for installation only, and can be deleted after the application is installed.
	 *
	 *  This application is designed for ArrowChat software (www.arrowchat.com).  ArrowChat is
	 *  NOT FREE SOFTWARE.  This application may or may not be free software.  If you have not
	 *  paid for this application, please verify it is free at the ArrowChat store
	 *  (www.arrowchat.com/store).  You must have an active ArrowChat license to install this
	 *  application.
	*/

	// REQUIRED
	// The name of the application.  Appears on the tooltip and app title.
	$application_name 	= "Bloons";
	
	// REQUIRED
	// The icon for the application located in the images folder.
	$application_icon	= "icon.gif";
	
	// REQUIRED
	// The application version.
	$application_version = "1.2";
	
	// REQUIRED
	// The folder the application is located within.
	$folder_location	= "bloons";
	
	// REQUIRED
	// If this value is set to 1, the application will not reload on open/close.
	// Only set this to 1 if you are sure the app can stay open.
	$dont_reload	= "0";
	
	// REQUIRED
	// Set to true if the application has a settings page (configure the settings.php file first!)
	$settings = false;
	
	// OPTIONAL
	// The application width if it is a popout.  Leave blank or 0 if link.
	$application_width	= "640";
	
	// OPTIONAL
	// The application height if it is a popout.  Leave blank or 0 if link.
	$application_height	= "480";
	
	// OPTIONAL
	// The URL that loads when clicking the application.  Leave blank if app is not a link.
	$application_link	= "";
	
	// OPTIONAL
	// A URL that displays the application's current version.  This will allow users to see if their 
	// application is up-to-date from the ArrowChat administration panel.  Must be a txt file.
	$update_link		= "http://www.arrowchat.com/updatecheck.php?id=1";

?>