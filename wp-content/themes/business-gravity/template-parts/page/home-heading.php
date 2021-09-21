<?php
/**
* Template for Home page's Heading Section
* @since Business Gravity 1.0.0
*/
?>
<div class="container">
	<div class="section-title-group">
		<h2 class="section-title"><?php echo get_the_title(); ?></h2>
		<span>
			<?php
				if( get_edit_post_link()){
					business_gravity_edit_link();
				}
			?>
		</span>
	</div>
	<?php if( $args[ 'sub_title' ] ): ?>
		<?php business_gravity_excerpt(25); ?>
	<?php endif; ?>
	<div class="button-container">
		<a href="<?php the_permalink(); ?>" class="button-primary">
			<?php esc_html_e( 'View More', 'business-gravity' ); ?>
		</a>
	</div>
</div>