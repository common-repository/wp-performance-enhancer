<?php
/*
Plugin Name: Wordpress Performance Enhancer
Description: Optimize your Wordpress or Wordpress MU installation
Version: 1.1
Author: Robert Lord, Codepeak AB
*/

// Define the root directory of the plugin
define('WPPE_BASE', dirname( __FILE__ ) . DIRECTORY_SEPARATOR);

// Include our class
require_once( WPPE_BASE . 'wppe.class.php');

// Add the menu
$wppe->addMenu();

if ( isset($_GET['do']) ) {
	
	switch ( $_GET['do'] ) {
		
		// Optimize database
		case 'optimize-db':
			$wppe->optimize_db();
			break;
			
		// Remove orphan postmeta
		case 'remove-orphan-postmeta':
			$wppe->findOrphanPostmeta(TRUE);
			break;

	}
	
}

