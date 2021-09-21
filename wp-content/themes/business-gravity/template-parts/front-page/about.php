<?php
/**
 * Template part for displaying about us section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
if( !business_gravity_get_option( 'disable_about' ) ):
	$id = business_gravity_get_option( 'about_page' );
	if( $id ):
		$query = new WP_Query( apply_filters( 'business_gravity_about_page_args',  array( 
			'post_type'  => 'page', 
			'p'          => $id, 
		)));
		while( $query->have_posts() ): 
			$query->the_post();
			$image = business_gravity_get_thumbnail_url( array(
				'size' => 'business-gravity-1170-710'
			));
	?>
	<!-- About Section -->
	<section class="wrapper block-about">
		<div class="thumb-block-outer">
			<div class="row align-items-center">
				<div class="col-md-6 pad0lr">
					<div class="thumb-outer">
						<div class="thumb-inner">
							<?php the_post_thumbnail( 'business-gravity-1170-710' ); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6 pad0lr">
					<div class="content-outer">
						<div class="section-title-group">
							<h2 class="section-title">
								<?php the_title(); ?>
							</h2>
							<span>
								<?php if( get_edit_post_link()){
									business_gravity_edit_link();
								} ?>
							</span>
						</div>
						<?php business_gravity_excerpt(40); ?>
						<div class="button-container">
							<a href="<?php the_permalink(); ?>" class="button-primary">
								<?php esc_html_e( 'View More', 'business-gravity' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> <!-- End About Section -->
	<?php 
		endwhile;
		wp_reset_postdata();
	endif;
endif;
