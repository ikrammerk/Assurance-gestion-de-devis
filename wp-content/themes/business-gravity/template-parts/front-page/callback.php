<?php
/**
 * Template part for displaying callback section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
if( !business_gravity_get_option( 'disable_callback' ) ): ?>
	
<!-- Callback Section -->
<section class="wrapper block-callback banner-content">
	<div class="banner-overlay">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-10 offset-md-1">
					<?php if( business_gravity_get_option( 'callback_title' ) ): ?>
						<h2 class="section-title"><?php echo wp_kses_post( business_gravity_get_option( 'callback_title' ) ); ?></h2>
					<?php endif; ?>
					<?php if( business_gravity_get_option( 'callback_button_text' ) ): ?>
						<div class="button-container">
							<a href="<?php echo wp_kses_post( business_gravity_get_option( 'callback_button_url' ) ); ?>" class="button-primary">
								<?php echo wp_kses_post( business_gravity_get_option( 'callback_button_text' ) ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section><!-- End Callback Section -->

<?php endif; ?>