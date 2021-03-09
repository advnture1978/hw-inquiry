<?php
/**
 * Plugin Name: Inquiry
 * Description: Add inquiry form and show inquiry lists in the pages.
 * Version: 1.0.1
 * Author: Andre Verona <advnture123@gmail.com>
 * Text Domain: inquiry
 * Domain Path: /languages/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

define( 'HW_INQUIRY_TABLE', $wpdb->prefix . 'inquiries' );
define( 'HW_INQUIRY_PLUGIN_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'HW_INQUIRY_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

/**
 * Include create custom table function file.
 */
require_once( HW_INQUIRY_PLUGIN_ABSPATH . 'inc/db.php' );

/**
 * Include main function file.
 */
require_once( HW_INQUIRY_PLUGIN_ABSPATH . 'inc/functions.php' );

/**
 * Include shortcode function file.
 */
require_once( HW_INQUIRY_PLUGIN_ABSPATH . 'inc/shortcodes.php' );

if ( ! function_exists( 'hw_inquiry_load_plugin_textdomain' ) ) {
	
	/**
	 * Load plugin textdomain.
	 */
	function hw_inquiry_load_plugin_textdomain() {
		load_plugin_textdomain( 'inquiry', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'hw_inquiry_load_plugin_textdomain', 1 );
}

// Call when the plugin activates. It creates custom table for the plugin.
register_activation_hook( __FILE__, 'hw_inquiry_create_inquiries_table' );