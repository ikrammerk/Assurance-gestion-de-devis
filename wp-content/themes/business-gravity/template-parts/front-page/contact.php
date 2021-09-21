<?php
/**
 * Template part for displaying contact section
 *
 * @since Business Gravity 1.0.0
 */

if( !business_gravity_get_option( 'disable_contact' ) ):
?>

<section class="wrapper block-contact">
	<div class="container">
		<?php if(!empty( business_gravity_get_option( 'contact_title' ) )): ?>
			<div class="section-title-group">
				<h2 class="section-title"><?php echo wp_kses_post( business_gravity_get_option( 'contact_title' ) ); ?></h2>
			</div>
		<?php endif; ?>
	</div>
	<div class="container contact-form-detail">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<div class="contact-form-section">
					<?php echo do_shortcode( business_gravity_get_option( 'contact_shortcode' ) ); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php endif;