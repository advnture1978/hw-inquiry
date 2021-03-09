<?php
/**
 * The template to display inquiry form.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="inquiry-form-wrapper">
	<h2 class="inquiry-title"><?php echo esc_html( $params['title'] ); ?></h2>
	<form class="inquiry-form">
		<div class="field">
			<label for="first-name"><?php echo esc_html__( 'First Name', 'inquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="first-name" class="form-control" name="first_name" value="<?php echo esc_attr( $params['first_name'] ); ?>" required>
		</div>
		<div class="field">
			<label for="last-name"><?php echo esc_html__( 'Last Name', 'inquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="last-name" class="form-control" name="last_name" value="<?php echo esc_attr( $params['last_name'] ); ?>" required>
		</div>
		<div class="field">
			<label for="email"><?php echo esc_html__( 'E-mail', 'inquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="email" id="email" class="form-control" name="email" value="<?php echo esc_attr( $params['email'] ); ?>" required>
		</div>
		<div class="field">
			<label for="subject"><?php echo esc_html__( 'Subject', 'inquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="subject" class="form-control" name="subject" required>
		</div>
		<div class="field">
			<label for="message"><?php echo esc_html__( 'Message', 'inquiry' ); ?></label>
			<textarea id="message" class="textarea" name="message"></textarea>
		</div>
		<div class="field">
			<button type="submit" class="btn btn-primary"><?php echo esc_html__( 'Submit', 'inquiry' ); ?></button>
		</div>
	</form>
</div>
