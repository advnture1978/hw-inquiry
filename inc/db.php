<?php
/**
 * Database custom table related file.
 * 
 * It includes all the functions related creating custom tables for the plugin.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hw_inquiry_create_inquiries_table' ) ) {

	/**
	 * Create custom table.
	 *
	 * Create the custom table for the plugin.
	 */
	function hw_inquiry_create_inquiries_table() {
		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE " . HW_INQUIRY_TABLE . " (
					id bigint(20) NOT NULL AUTO_INCREMENT,
					first_name varchar(255) DEFAULT NULL,
					last_name varchar(255) DEFAULT NULL,
					email varchar(255) DEFAULT NULL,
					subject varchar(255) DEFAULT NULL,
					message text DEFAULT NULL,
					PRIMARY KEY	(id)
				) $charset_collate;";
		dbDelta($sql);
	}
}
