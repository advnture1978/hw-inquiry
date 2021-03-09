<?php
/*
 * Functions file.
 * 
 * It includes all the functions for the plugin except shortcode function.
 *
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/plugin/templates/$template_name
 *
 * @param	string	$template_name			Template to load.
 * @param	string	$template_path			Path to templates.
 * @param	string	$default_path			Default path to template files.
 * @return	string							Path to the template file.
 */
function hw_inquiry_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	// Set variable to search in the templates folder of theme.
	if ( ! $template_path ) {
		$template_path = 'templates/';
	}

	// Set default plugin templates path.
	if ( ! $default_path ) {
		$default_path = HW_INQUIRY_PLUGIN_ABSPATH . 'templates/';
	}

	// Search template file in theme folder.
	$template = locate_template(
		array(
			$template_path . $template_name,
			$template_name,
		)
	);

	// Get plugins template file.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	return apply_filters( 'hw_inquiry_locate_template', $template, $template_name, $template_path, $default_path );
}

/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @param	string	$template_name			Template to load.
 * @param	string	$params					Parameters pass to templates.
 * @param	string	$template_path			Path to templates.
 * @param	string	$default_path			Default path to template files.
 * @return	string							Path to the template file.
 */
function hw_inquiry_get_template( $template_name, $params = array(), $tempate_path = '', $default_path = '' ) {

	$template_file = hw_inquiry_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
		return;
	}

	include $template_file;
}

if ( ! function_exists( 'hw_inquiry_person_info' ) ) {

	/**
	 * Get user information.
	 *
	 * Get user information if user logged in.
	 *
	 * @return	array	{
	 *		User information.
	*
	*		@type string "first_name"	User's first name.
	* 		@type string "last_name"	User's last name.
	* 		@type string "email"		User's email address.
	* }
	*/
	function hw_inquiry_person_info() {
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			return array(
				'first_name'	=> $current_user->user_firstname,
				'last_name'		=> $current_user->user_lastname,
				'email'			=> $current_user->user_email,
			);
		}

		return array(
			'first_name'	=> '',
			'last_name'		=> '',
			'email'			=> '',
		);
	}
}

if ( ! function_exists( 'hw_inquiry_scripts' ) ) {

	/**
	 * Register script.
	 *
	 * Register js files and css files for the plugin.
	 */
	function hw_inquiry_scripts() {
		wp_register_style( 'hw-inquiry-styles', HW_INQUIRY_PLUGIN_URI . '/css/styles.css' );
		wp_register_script( 'hw-inquiry-scripts', HW_INQUIRY_PLUGIN_URI . '/js/scripts.js', array( 'jquery' ) );
	}

	add_action( 'wp_enqueue_scripts', 'hw_inquiry_scripts' );
}

if ( ! function_exists( 'hw_inquiry_get_ajax_default_data' ) ) {

	/**
	 * Get default ajax data.
	 *
	 * Get default data used in all the ajax functionalities.
	 *
	 * @return	array	{
	 * 		Default ajax data
	 * 
	 * 		@type	string	"ajaxurl"		Url to send ajax.
	 * 		@type	string	"ajax_nonce"	Nonce for the security.
	 * }
	 */
	function hw_inquiry_get_ajax_default_data() {
		return array(
			'ajaxurl'		=> admin_url( 'admin-ajax.php'),
			'ajax_nonce'	=> wp_create_nonce( 'inquiry-ajax' ),
		);
	}
}

if ( ! function_exists( 'hw_inquiry_save_inquiry_data' ) ) {

	/**
	 * Save inquiry data.
	 *
	 * Save inquiry data to the table.
	 *
	 * @param	array	$data	{
	 * 		Data to save to the table.
	 * 
	 * 		@type	string	first_name	User's first name.
	 * 		@type	string	last_name	User's last name.
	 * 		@type	string	email		User's email address.
	 * 		@type	string	subject		Subject of the inquiry.
	 * 		@type	string	message		Message content of the inquiry.
	 * }
	 * @return	bool			Inserted status. True if inserted successfully.
	 */
	function hw_inquiry_save_inquiry_data( $data ) {
		global $wpdb;
		return $wpdb->insert( HW_INQUIRY_TABLE, $data );
	}
}

if ( ! function_exists( 'hw_inquiry_ajax_send_inquiry_info' ) ) {

	/**
	 * Handle inquiry information.
	 *
	 * Handle inqiury information sent via ajax.
	 */
	function hw_inquiry_ajax_send_inquiry_info() {
		// verifies the Ajax request
		check_ajax_referer( 'inquiry-ajax', 'nonce' );

		$data = array();

		// validate first name
		if ( empty( $_POST['first_name'] ) ) {
			$message = esc_html__( "Please enter your first name", 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}

		// validate last name
		if ( empty( $_POST['last_name'] ) ) {
			$message = esc_html__( "Please enter your last name", 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}

		// validate email
		if ( empty( $_POST['email'] ) || ! is_email( $_POST['email'] ) ) {
			$message = esc_html__( "Please enter your email.", 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}

		// validate subject
		if ( empty( $_POST['subject'] ) ) {
			$message = esc_html__( "Please enter the subject.", 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}

		$data = array(
			'first_name'	=> sanitize_text_field( $_POST['first_name'] ),
			'last_name'		=> sanitize_text_field( $_POST['last_name'] ),
			'email'			=> sanitize_email( $_POST['email'] ),
			'subject'		=> sanitize_text_field( $_POST['subject'] ),
			'message'		=> wp_filter_nohtml_kses( $_POST['message'] ),
		);

		$result = hw_inquiry_save_inquiry_data( $data );

		if ( $result ) {
			$message = esc_html__( 'Thank you for sending us your feedback', 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'success',
					'message'	=> $message,
				)
			);
		}

		$message = esc_html__( 'Error occured. Please try again later', 'inquiry' );
		wp_send_json(
			array(
				'result'	=> 'fail',
				'message'	=> $message,
			)
		);
	}
	
	add_action( 'wp_ajax_hw_send_inquiry_info', 'hw_inquiry_ajax_send_inquiry_info' );
	add_action( 'wp_ajax_nopriv_hw_send_inquiry_info', 'hw_inquiry_ajax_send_inquiry_info' );
}

if ( ! function_exists( 'hw_inquiry_get_inquiry_list' ) ) {

	/**
	 * Get inquiry list.
	 *
	 * Get inquiry informations from database.
	 *
	 * @param	int		page		Current page number.
	 * @param	int 	per_page	The number of inquiry shown in the page.
	 * @return	array				array of the inquiries.
	 */
	function hw_inquiry_get_inquiry_list( $page = 1, $per_page = 10 ) {
		global $wpdb;

		$sql	= $wpdb->prepare( 'SELECT * FROM %1$s LIMIT %2$s, %3$s', HW_INQUIRY_TABLE, $per_page * ( $page - 1 ), $per_page );
		$result	= $wpdb->get_results( $sql, ARRAY_A );

		return $result;
	}
}

if ( ! function_exists( 'hw_inquiry_get_inquiry_by_id' ) ) {

	/**
	 * Get inquiry information.
	 *
	 * Get inquiry information from database by inquiry id.
	 *
	 * @param	int		id			Inquiry ID.
	 * @return	array				Inquiry information.
	 */
	function hw_inquiry_get_inquiry_by_id( $id ) {
		global $wpdb;

		$sql	= $wpdb->prepare( 'SELECT * FROM %1$s WHERE id=%2$s', HW_INQUIRY_TABLE, $id );
		$result	= $wpdb->get_row( $sql, ARRAY_A );

		return $result;
	}
}

if ( ! function_exists( 'hw_inquiry_get_inquiry_total_count' ) ) {

	/**
	 * Get total count of inquiries.
	 *
	 * @return	int				Total count of inquiries.
	 */
	function hw_inquiry_get_inquiry_total_count() {
		global $wpdb;

		$sql	= $wpdb->prepare( 'SELECT count(*) FROM %1$s', HW_INQUIRY_TABLE );
		$result = $wpdb->get_var( $sql );

		return $result;
	}
}

if ( ! function_exists( 'hw_inquiry_ajax_get_inquiry_list' ) ) {

	/**
	 * Handle get inquiry list ajax request.
	 * 
	 * Handle get inquiry list ajax request and send inquiry list html.
	 */
	function hw_inquiry_ajax_get_inquiry_list() {
		// verifies the Ajax request
		check_ajax_referer( 'inquiry-ajax', 'nonce' );

		// return if not administrator
		if ( ! current_user_can( 'administrator' ) ) {
			$message = esc_html__( 'Please login as Administrator.', 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}
		
		if ( empty( $_POST['page'] ) || 0 == intval( $_POST['page'] ) ) {
			$page = 1;
		} else {
			$page = intval( $_POST['page'] );
		}

		if ( empty( $_POST['per_page'] ) || 0 == intval( $_POST['per_page'] ) ) {
			$per_page = 10;
		} else {
			$per_page = intval( $_POST['per_page'] );
		}

		$inquiry_list = hw_inquiry_get_inquiry_list( $page, $per_page );
		$inquiry_total_count = hw_inquiry_get_inquiry_total_count();

		ob_start();
		hw_inquiry_get_template(
			'hw-inquiry-list.php',
			array( 
				'inquiry_list'			=> $inquiry_list,
				'inquiry_total_count'	=> $inquiry_total_count,
				'per_page'				=> $per_page,
				'page'					=> $page,
			)
		);
		$output = ob_get_clean();

		wp_send_json(
			array(
				'result'	=> 'success',
				'html'		=> $output,
			)
		);
	}

	add_action( 'wp_ajax_hw_get_inquiry_list', 'hw_inquiry_ajax_get_inquiry_list' );
}

if ( ! function_exists( 'hw_inquiry_ajax_get_inquiry_info' ) ) {

	/**
	 * Handle get inquiry info ajax.
	 *
	 * Handle get inquiry info ajax request and send inquiry information html.
	 */
	function hw_inquiry_ajax_get_inquiry_info() {
		// verifies the Ajax request
		check_ajax_referer( 'inquiry-ajax', 'nonce' );

		// return if not administrator
		if ( ! current_user_can( 'administrator' ) ) {
			$message = esc_html__( 'Please login as Administrator.', 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}
		
		// return if inquiry_id is null
		if ( empty( $_POST['inquiry_id'] ) ) {
			$mesage = esc_html__( 'Error Occurred, please try again later.', 'inquiry' );
			wp_send_json(
				array(
					'result'	=> 'fail',
					'message'	=> $message,
				)
			);
		}

		$inquiry_info = hw_inquiry_get_inquiry_by_id( $_POST['inquiry_id'] );

		ob_start();
		hw_inquiry_get_template(
			'hw-inquiry-info.php',
			array( 'inquiry' => $inquiry_info )
		);
		$output = ob_get_clean();

		wp_send_json(
			array(
				'result'	=> 'success',
				'html'		=> $output,
			)
		);
	}
	
	add_action( 'wp_ajax_hw_get_inquiry_info', 'hw_inquiry_ajax_get_inquiry_info' );
}
