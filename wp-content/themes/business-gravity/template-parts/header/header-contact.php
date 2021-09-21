<?php
/**
 * Displays header contact
 * @since Business Gravity 1.0.0
 */
?>

<div class="header-contact" id="header-contact-area">
	<div class="top-header-left">
		<?php if ( business_gravity_get_option( 'top_header_address') ): ?>
			<div class="list">
				<span class="kfi kfi-pin-alt"></span>
				<?php echo wp_kses_post(  business_gravity_get_option( 'top_header_address' ) ); ?>
			</div>
		<?php endif; ?>
		<?php if ( business_gravity_get_option( 'top_header_email') ): ?>
			<div class="list">
				<span class="kfi kfi-mail-alt"></span>
				<a href="mailto:<?php echo wp_kses_post(  business_gravity_get_option( 'top_header_email' ) ); ?>">
					<?php echo wp_kses_post(  business_gravity_get_option( 'top_header_email' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( business_gravity_get_option( 'top_header_phone') ): ?>
			<div class="list">
				<span class="kfi kfi-phone"></span>
				<a href="tel:<?php echo wp_kses_post(  business_gravity_get_option( 'top_header_phone' ) ); ?>">
					<?php echo wp_kses_post(  business_gravity_get_option( 'top_header_phone' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>