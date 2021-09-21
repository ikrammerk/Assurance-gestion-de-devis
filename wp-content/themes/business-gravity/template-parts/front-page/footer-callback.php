<?php
/**
 * Template part for displaying footer callback section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
if( !business_gravity_get_option( 'disable_footer_callback' ) ): ?>
	
<!-- Callback Section -->
<section class="wrapper block-footer-callback banner-content">
	<div class="banner-overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<?php if( business_gravity_get_option( 'footer_callback_title' ) ): ?>
						<h2 class="section-title"><?php echo wp_kses_post( business_gravity_get_option( 'footer_callback_title' ) ); ?></h2>
					<?php endif; ?>
					<div class="subcription-form-section">
						<?php echo do_shortcode( business_gravity_get_option( 'footer_callback_shortcode' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section><!-- End Footer Callback Section -->

<?php endif; ?>