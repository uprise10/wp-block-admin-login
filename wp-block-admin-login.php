<?php
/*
Plugin Name: WP Block Admin Login
Plugin URI: http://www.uprise.nl
Description: Blocks "admin" user by default form loggin in. Really helpful against spammers!
Version: 1.0
Author: Uprise
Author URI: http://www.uprise.nl
*/

// Include classes
require_once( 'classes/class-core.php' );
require_once( 'classes/class-forms.php' );
require_once( 'classes/class-settings.php' );

// Load classes
$wpba_core     = WP_Block_Admin_Login_Core::instance();
$wpba_settings = WP_Block_Admin_Login_Settings::instance();