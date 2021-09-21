<?php
/**
 * Template part for displaying services section
 *
 * @since Insurance Gravity 1.0.0
 */

if( !business_gravity_get_option( 'disable_service' ) ):

	$srvc_ids = business_gravity_get_ids( 'service_page' );
	if( !empty( $srvc_ids ) && is_array( $srvc_ids ) && count( $srvc_ids ) > 0 ):

		$query = new WP_Query( apply_filters( 'business_gravity_services_args',  array( 
			'post_type'      => 'page',
			'post__in'       => $srvc_ids,
			'posts_per_page' => 4,
			'orderby'        => 'post__in'
		)));

		if( $query->have_posts() ):
?>
			<!-- Service Section -->
			<section class="wrapper block-service">
				<div class="container">
					<div class="row align-items-center">
							<?php 
								business_gravity_section_heading( array( 
									'id'        => 'service_main_page',
									'sub_title' => false								
								));
							?>
						<div class="col-md-12 service-item-wrap">
						<div class="row">
				    		<?php
				    			$count = $query->post_count;
					    		while( $query->have_posts() ):
					    			$query->the_post();
					    			$title = business_gravity_get_piped_title();
					    			if( 1 == $count ){
					    				$class = 'col-12';
					    				$excerpt_length = 20;
					    			}else{
					    				$class = 'col-12 col-md-6';
					    				$excerpt_length = 10;
					    			}
					    	?>
							    	<div class="<?php echo esc_attr( $class ); ?>">
							    		<div class="icon-block-outer">
							    			<div class="post-content-inner">
							    				<div class="list-inner">
						    						<?php 
						    							$icon = $title[ 'sub_title' ] ;
						    							if( !empty( $icon ) ):
						    						?>
						    								<div class="icon-area">
						    									<span class="icon-outer">
						    										<span class="kfi <?php echo esc_attr( $icon ); ?>"></span>
						    									</span>
						    								</div>
						    						<?php endif; ?>
													<div class="icon-content-area">
							    						<h3>
							    							<a href="<?php the_permalink(); ?>">
							    								<?php echo esc_html( $title[ 'title' ] ); ?>
							    							</a>
							    						</h3>
							    						<div class="text">
							    							<?php 
							    								business_gravity_excerpt( $excerpt_length, true, '&hellip;' );
							    								if( get_edit_post_link()){
			    													business_gravity_edit_link();
			    												}
							    							?>
							    						</div>
													</div>
							    				</div>
							    			</div>
							    		</div>
							    	</div>
							<?php  
								endwhile;
								wp_reset_postdata();
							?>
							</div>
						</div>
					</div>
				</div>
			</section> <!-- End Service Section -->
<?php
		endif; 
	endif; 
endif;