<?php
/**
 * Displays fixed header site branding
 * @since Business Gravity 1.0.0
 */
?>

<div class="site-branding-outer clearfix">
	<div class="site-branding">
	<?php
		$image = business_gravity_get_option( 'fixed_header_logo' );
		if( $image ){
			?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( $image ); ?>">
				</a>
			<?php
		}else{
			the_custom_logo();
		}
		
		if( display_header_text() ){
			
			if ( is_front_page() && ! is_home() ){
	?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
	<?php		
			}else{
	?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</p>
	<?php
			}
	?>
			<p class="site-description">
				<?php echo get_bloginfo( 'description', 'display' ); ?>
			</p>
	<?php
		}
	?>
	</div><!-- .site-branding -->
</div>