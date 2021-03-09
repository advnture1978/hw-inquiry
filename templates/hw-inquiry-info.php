<?php
/**
 * The template to display inquiry information details.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( empty( $params['inquiry'] ) ) : ?>
	<p class="notification"><?php esc_html__( 'There is no inquiry data.', 'inquiry' ); ?></p>
<?php else : ?>

	<h3><?php echo esc_html__( 'inquiry Information', 'inquiry' ); ?></h3>

	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'First Name', 'inquiry' ); ?>:</div>
		<div class="value"><?php echo esc_html( $params['inquiry']['first_name'] ); ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Last Name', 'inquiry' ); ?>:</div>
		<div class="value"><?php echo esc_html( $params['inquiry']['last_name'] ); ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Email', 'inquiry' ); ?>:</div>
		<div class="value"><?php echo esc_html( $params['inquiry']['email'] ); ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Subject', 'inquiry' ); ?>:</div>
		<div class="value"><?php echo esc_html( $params['inquiry']['subject'] ); ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Message', 'inquiry' ); ?>:</div>
		<div class="value"><?php echo esc_html( $params['inquiry']['message'] ); ?></div>
	</div>
	
<?php endif; ?>
