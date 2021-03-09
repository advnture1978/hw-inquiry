<?php
/**
 * The template to display inquiry list.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( empty( $params['inquiry_list'] ) ) : ?>
	<p class="notification"><?php esc_html__( 'There is no inquiry data.', 'inquiry' ); ?></p>
<?php else : ?>

	<div class="inquiry-fields-wrapper">
		<div class="inquiry-field"><?php echo esc_html__( 'First Name', 'inquiry' ); ?></div>
		<div class="inquiry-field"><?php echo esc_html__( 'Last Name', 'inquiry' ); ?></div>
		<div class="inquiry-field"><?php echo esc_html__( 'Email', 'inquiry' ); ?></div>
		<div class="inquiry-field"><?php echo esc_html__( 'Subject', 'inquiry' ); ?></div>
	</div>
	
	<?php foreach( $params['inquiry_list'] as $inquiry ) : ?>
		<div class="inquiry-info inquiry-item" data-inquiry-id="<?php echo $inquiry['id']; ?>">
			<div class="inquiry-info-value"><?php echo esc_html( $inquiry['first_name'] ); ?></div>
			<div class="inquiry-info-value"><?php echo esc_html( $inquiry['last_name'] ); ?></div>
			<div class="inquiry-info-value"><?php echo esc_html( $inquiry['email'] ); ?></div>
			<div class="inquiry-info-value"><?php echo esc_html( $inquiry['subject'] ); ?></div>
		</div>
	<?php endforeach; ?>

	<div class="inquiry-pagination">
		<?php
			$pagenum_link = '%_%';
			$total = ceil( $params['inquiry_total_count'] / $params['per_page'] );
			$args = array(
				'base'		=> $pagenum_link,
				'total'		=> $total,
				'format'	=> '?page=%#%',
				'current'	=> $params['page'],
				'show_all'	=> false,
				'prev_next'	=> true,
				'prev_text'	=> esc_html__( 'Prev', 'inquiry' ),
				'next_text'	=> esc_html__( 'Next', 'inquiry' ),
				'end_size'	=> 1,
				'mid_size'	=> 1,
				'type'		=> 'list',
				'add_args'	=> array( 'per_page' => $params['per_page'] ),
			);

			echo paginate_links( $args );
		?>
	</div>
<?php endif; ?>
