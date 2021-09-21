<?php
/**
 * Displays header callback button
 * @since Business Gravity 1.0.0
 */
?>

<span class="callback-button">
	<a href="<?php echo wp_kses_post( business_gravity_get_option( 'header_button_url' ) ); ?>" class="default-button">
		<?php echo wp_kses_post( business_gravity_get_option( 'header_button_text' ) ); ?>
	</a>
</span>