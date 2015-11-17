<?php /*
--------------------------------------------------------------------------------
Plugin Name: BuddyPress Dropdown Login Panel
Description: A dropdown login panel with account centre for BuddyPress.
Author: Christian Wach
Author URI: http://haystack.co.uk
Plugin URI: http://haystack.co.uk
Version: 3.0.1
License: CC-GNU-GPL
License URI: http://creativecommons.org/licenses/GPL/2.0/
Text Domain: bp-dropdown-login-panel
Domain Path: /languages
--------------------------------------------------------------------------------
This is a fork of the BuddyPress Sliding Login Panel written by Sarah Gooding.
@see https://wordpress.org/plugins/buddypress-sliding-login-panel/
--------------------------------------------------------------------------------
*/



// set our version here
define( 'BP_DROPDOWN_LOGIN_VERSION', '3.0.1' );

// store reference to this file
if ( !defined( 'BP_DROPDOWN_LOGIN_FILE' ) ) {
	define( 'BP_DROPDOWN_LOGIN_FILE', __FILE__ );
}

// store URL to this plugin's directory
if ( !defined( 'BP_DROPDOWN_LOGIN_URL' ) ) {
	define( 'BP_DROPDOWN_LOGIN_URL', plugin_dir_url( BP_DROPDOWN_LOGIN_FILE ) );
}

// store PATH to this plugin's directory
if ( !defined( 'BP_DROPDOWN_LOGIN_PATH' ) ) {
	define( 'BP_DROPDOWN_LOGIN_PATH', plugin_dir_path( BP_DROPDOWN_LOGIN_FILE ) );
}



/**
 * Plugin wrapper class.
 *
 * @package BP_Dropdown_Login_Panel
 * @subpackage Core
 */
class BP_Dropdown_Login_Panel {



	/**
	 * Instantiates this object.
	 *
	 * @return object $this The BP_Dropdown_Login_Panel instance
	 */
	public function __construct() {

		// init when BP is inited
		add_action( 'bp_init', array( $this, 'initialise' ) );

		// add translation
		add_action( 'plugins_loaded', array( $this, 'translation' ) );

		// --<
		return $this;

	}



	/**
	 * Initialises this object.
	 *
	 * @return void
	 */
	public function initialise() {

		// include display functions
		require( BP_DROPDOWN_LOGIN_PATH . '/bp-dropdown-login-panel-content.php' );

		// enqueue assets
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

		// inject plugin content
		add_action( 'bp_before_header', array( $this, 'show_panel' ) );

		// show login form (may be unhooked by other plugins)
		add_action( 'bp_dropdown_login_panel_anon_after_register', 'bp_dropdown_login_panel_show_login_form' );

	}



	/**
	 * Loads translation, if present.
	 *
	 * @return void
	 */
	public function translation() {

		// only use if it exists
		if ( function_exists( 'load_plugin_textdomain' ) ) {

			// add translation files
			load_plugin_textdomain(

				// unique name
				'bp-dropdown-login-panel',

				// deprecated argument
				false,

				// relative path to directory containing translation files
				dirname( plugin_basename( BP_DROPDOWN_LOGIN_FILE ) ) . '/languages/'

			);

		}

	}



	/**
	 * Add HTML to page.
	 *
	 * @return void
	 */
	public function show_panel() {

		// pass to global scope function
		bp_dropdown_login_panel_show_header();

	}



	/**
	 * Add our script and style resources.
	 *
	 * @return void
	 */
	public function enqueue_assets() {

		// JavaScript
		wp_enqueue_script(
			'bp-dropdown-login-js', // handle
			plugins_url( 'assets/js/bp-dropdown-login-panel.js', BP_DROPDOWN_LOGIN_FILE ),
			array('jquery', 'jquery-form'), // dependencies
			BP_DROPDOWN_LOGIN_VERSION, // version
			false // in footer
		);

		// screen CSS
		wp_enqueue_style(
			'bp-dropdown-login-css',
			plugins_url( 'assets/css/bp-dropdown-login-panel.css', BP_DROPDOWN_LOGIN_FILE ),
			null, // dependencies
			BP_DROPDOWN_LOGIN_VERSION, // version
			'screen' // media
		);

		// print CSS
		wp_enqueue_style(
			'bp-dropdown-login-print-css',
			plugins_url( 'assets/css/bp-dropdown-login-panel-print.css', BP_DROPDOWN_LOGIN_FILE ),
			null, // dependencies
			BP_DROPDOWN_LOGIN_VERSION, // version
			'print' // media
		);

	}



} // end BP_Dropdown_Login_Panel



// init plugin
global $bp_dropdown_login_panel;
$bp_dropdown_login_panel = new BP_Dropdown_Login_Panel;
