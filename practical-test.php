<?php
/*
Plugin Name: Practical Test - Blogs based on locations
Plugin URI: https://www.google.com/
Description: Custom feature to display blogs based on location tags on Leaflet Interactive maps.
Version: 1.0.0
Author: Karan Shah
Author URI: https://www.google.com/
*/

/**
 * Basic plugin definitions 
 * 
 * @package Practical Test
 * @since 1.0.0
 */
if( !defined( 'PRACT_TEST_DIR' ) ) {
  define( 'PRACT_TEST_DIR', dirname( __FILE__ ) );      // Plugin dir
}
if( !defined( 'PRACT_TEST_VERSION' ) ) {
  define( 'PRACT_TEST_VERSION', '1.0.3' );      // Plugin Version
}
if( !defined( 'PRACT_TEST_URL' ) ) {
  define( 'PRACT_TEST_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}
if( !defined( 'PRACT_TEST_INC_DIR' ) ) {
  define( 'PRACT_TEST_INC_DIR', PRACT_TEST_DIR.'/includes' );   // Plugin include dir
}
if( !defined( 'PRACT_TEST_INC_URL' ) ) {
  define( 'PRACT_TEST_INC_URL', PRACT_TEST_URL.'includes' );    // Plugin include url
}
if( !defined( 'PRACT_TEST_ADMIN_DIR' ) ) {
  define( 'PRACT_TEST_ADMIN_DIR', PRACT_TEST_INC_DIR.'/admin' );  // Plugin admin dir
}
if(!defined('PRACT_TEST_PREFIX')) {
  define('PRACT_TEST_PREFIX', 'pract_test'); // Plugin Prefix
}
if(!defined('PRACT_TEST_VAR_PREFIX')) {
  define('PRACT_TEST_VAR_PREFIX', '_prac_test_'); // Variable Prefix
}
if(!defined('LOCATION_IQ_TOKEN')) {
    define('LOCATION_IQ_TOKEN', 'pk.b7bc898e79a3b1cb696b525c20d1b864'); // Variable Prefix
}
if(!defined('LOCATION_IQ_ENDPOINT')) {
    define('LOCATION_IQ_ENDPOINT', 'https://us1.locationiq.com/v1/search'); // Variable Prefix
}
  


/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package Practical Test
 * @since 1.0.0
 */
load_plugin_textdomain( 'practest', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Practical Test
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'prac_test_install' );

function prac_test_install(){
	
}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package Practical Test
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'prac_test_uninstall');

function prac_test_uninstall(){
  
}

// Global variables
global $prac_test_scripts , $prac_test_admin , $prac_test_shortcodes , $prac_test_shortcodes;

// Script class handles most of script functionalities of plugin
include_once( PRACT_TEST_DIR.'/class-practical-test-scripts.php' );
$prac_test_scripts = new Practical_Test_Scripts();
$prac_test_scripts->add_hooks();

// Admin class handles most of admin panel functionalities of plugin
include_once( PRACT_TEST_ADMIN_DIR.'/prac-test-admin.php' );
$prac_test_admin = new Prac_Test_Admin();
$prac_test_admin->add_hooks();

// Shortcodes class handles all the shortcodes displayed on the front-end
include_once( PRACT_TEST_INC_DIR.'/public/class-practical-test-shortcodes.php' );
$prac_test_shortcodes = new Practical_Test_Shortcodes();
$prac_test_shortcodes->add_hooks();

