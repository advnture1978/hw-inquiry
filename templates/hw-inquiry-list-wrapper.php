<?php
/**
 * The template to display inquiry list wrapper.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="inquiry-list-wrapper">
	<h2 class="inquiry-title"><?php echo esc_html( $params['title'] ); ?></h2>

	<div class="inquiry-list">
		<?php
			hw_inquiry_get_template(
				'hw-inquiry-list.php',
				array( 
					'inquiry_list'			=> $params['inquiry_list'],
					'inquiry_total_count'	=> $params['inquiry_total_count'],
					'per_page'				=> $params['per_page'],
					'page'					=> 1,
				)
			);
		?>
	</div>

	<div class="inquiry-details"></div>
</div>
