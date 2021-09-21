<?php
/**
 * Template part for displaying portfolio section
 *
 * @since Business Gravity 1.0.0
 */
?>

<?php 
if( !business_gravity_get_option( 'disable_portfolio' ) ):

	$portfolio_ids = business_gravity_get_ids( 'portfolio_page' );
	if( !empty( $portfolio_ids ) && is_array( $portfolio_ids ) && count( $portfolio_ids ) > 0 ):

		$query = new WP_Query( apply_filters( 'business_gravity_portfolio_args',  array( 
			'post_type'      => 'page',
			'post__in'       => $portfolio_ids, 
			'posts_per_page' => 4,
			'orderby'        => 'post__in'
		)));

	if( $query->have_posts() ):
		?>
		<!-- Portfolio Section -->
		<section class="wrapper block-portfolio block-grid">
			<?php if(!empty( business_gravity_get_option( 'portfolio_title' ) )): ?>
				<div class="section-title-group">
					<h2 class="section-title"><?php echo wp_kses_post( business_gravity_get_option( 'portfolio_title' ) ); ?></h2>
				</div>
			<?php endif; ?>
			<div class="container">
				<div class="row">
					<?php
					$count = $query->post_count;
					while( $query->have_posts() ): 
						$query->the_post();

						$image = business_gravity_get_thumbnail_url( array(
							'size' => 'business-gravity-1170-710'
						));
						?>
						<div class="masonry-grid">
							<article class="gallery-content">
								<div class="post-thumb-outer">
									<div class="post-thumb">
										<img src="<?php echo esc_url( $image ); ?>" />
										<a href="<?php the_permalink(); ?>">
											<div class="post-content-inner">
												<div class="post-title">
													<h3>
														<?php the_title(); ?>
													</h3>
												</div>
												<div class="icon-area">
													<span class="icon-outer">
														<span class="kfi kfi-link-alt"></span>
													</span>
												</div>
											</div>
										</a>
									</div>
								</div>
							</article>
							<?php 
							if( get_edit_post_link()){
								business_gravity_edit_link();
							}
							?>
						</div>
						<?php  
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section> <!-- End Portfolio Section -->
		<?php
	endif; 
endif; 
endif;
?>