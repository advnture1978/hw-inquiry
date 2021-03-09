<?php
/*
 * Shortcode function file.
 * 
 * It includes shortcode related functions.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hw_inquiry_clean_shortcodes' ) ) {

	/**
	 * Clean content for the plugin shortcode.
	 * 
	 * Remove p and br tags before and after shortcodes in content.
	 * 
	 * @return	string			Cleaned content.
	 */
	function hw_inquiry_clean_shortcodes( $content ) {
		$array = array (
			'<p>['		=> '[',
			']</p>'		=> ']',
			']<br />'	=> ']',
		);

		$content = strtr( $content, $array );
		$content = preg_replace( "/<br \/>.\[/s", "[", $content );

		return $content;
	}

	add_filter( 'the_content', 'hw_inquiry_clean_shortcodes' );
}

/**
 * Shortcode [hw_inquiry_form].
 * 
 * Handle shortcode hw_inquiry_form.
 * 
 * @return	string			Shortcode content with html.
 */
function hw_inquiry_shortcode_inquiry_form( $atts, $content = null ) {	
	$inquiry_form_atts = shortcode_atts(
		array(
			'title' => esc_html__( 'Submit your feedback', 'inquiry' ),
		),
		$atts
	);

	$form_info = hw_inquiry_person_info();
	$form_info['title'] = $inquiry_form_atts['title'];

	wp_enqueue_style( 'hw-inquiry-styles' );

	$ajax_data = hw_inquiry_get_ajax_default_data();
	wp_localize_script( 'hw-inquiry-scripts', 'ajax_data', $ajax_data );	
	wp_enqueue_script( 'hw-inquiry-scripts' );

	ob_start();
	hw_inquiry_get_template( 'hw-inquiry-form.php', $form_info );
	$output = ob_get_clean();

	return $output;
}

/**
 * Shortcode [hw_inquiry_list].
 * 
 * Handle shortcode hw_inquiry_list.
 * 
 * @return	string			Shortcode content with html.
 */
function hw_inquiry_shortcode_inquiry_list( $atts, $content = null ) {	
	$inquiry_list_atts = shortcode_atts(
		array(
			'title'		=> esc_html__( 'Inquiry List', 'inquiry' ),
			'per_page'	=> 10,
		),
		$atts
	);

	// return if not administrator
	if ( ! current_user_can( 'administrator' ) ) {
		return "";
	}

	wp_enqueue_style( 'hw-inquiry-styles' );

	$ajax_data = hw_inquiry_get_ajax_default_data();
	wp_localize_script( 'hw-inquiry-scripts', 'ajax_data', $ajax_data );	
	wp_enqueue_script( 'hw-inquiry-scripts' );

	$inquiry_list = hw_inquiry_get_inquiry_list( 1, $inquiry_list_atts['per_page'] );
	$inquiry_total_count = hw_inquiry_get_inquiry_total_count();

	ob_start();
	hw_inquiry_get_template(
		'hw-inquiry-list-wrapper.php',
		array( 
			'title'					=> $inquiry_list_atts['title'],
			'inquiry_list'			=> $inquiry_list,
			'inquiry_total_count'	=> $inquiry_total_count,
			'per_page'				=> $inquiry_list_atts['per_page'],
			'page'					=> 1,
		)
	);
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'hw_inquiry_list', 'hw_inquiry_shortcode_inquiry_list' );
add_shortcode( 'hw_inquiry_form', 'hw_inquiry_shortcode_inquiry_form' );
