<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
?>
<?php $class = ''; ?>
<?php business_gravity_get_option( 'archive_post_layout' ) == 'grid' ? $class = 'masonry-grid' : $class = 'masonry-grid wrap-post-list'; ?>
<div class="<?php echo esc_attr( $class ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-wrap' ); ?>>
		<?php $align_class = ''; ?>
		<?php if( business_gravity_get_option( 'archive_post_image_alignment' ) == 'left' ){
			$align_class = 'text-left';
		}elseif( business_gravity_get_option( 'archive_post_image_alignment' ) == 'right' ){
			$align_class = 'text-right';
		}else {
			$align_class = 'text-center';
		}
		?>

		<div class="thumb-outer <?php echo $align_class; ?>">
			<div class="thumb-inner">
				<?php
				if( business_gravity_get_option( 'archive_post_image' ) == 'thumbnail' ){
					$size = 'thumbnail';
				}elseif( business_gravity_get_option( 'archive_post_image' ) == 'medium'){
					$size = 'medium';
				}elseif( business_gravity_get_option( 'archive_post_image' ) == 'large'){
					$size = 'large';
				}else {
					$size = 'business-gravity-1170-710';
				}
				$args = array(
					'size' => $size,
				);

				# Disabling dummy thumbnails when its in search page, also support for jetpack's infinite scroll
				if( 'post' != get_post_type() && business_gravity_is_search() ){
					$args[ 'dummy' ] = false;
				}

				business_gravity_post_thumbnail( $args );
				?>
			</div>
			<?php
				if( 'post' == get_post_type() ){
			?>
			<div class="meta">
				<div class="meta-date">
					<a href="<?php echo esc_url( business_gravity_get_day_link() ); ?>" class="date">
						<span class="day">
							<?php
							echo esc_html(get_the_date('j')); ?>
						</span>
						<span class="month">
							<?php
							echo esc_html(get_the_date('M')); ?>
						</span>
						<span class="year">
							<?php
							echo esc_html(get_the_date('Y')); ?>
						</span>
					</a>
				</div>
				<?php
					$cat = business_gravity_get_the_category();
					if( $cat ):
						?>
						<span class="cat">
							<?php
							$term_link = get_category_link( $cat[ 0 ]->term_id );
							?>
							<a href="<?php echo esc_url( $term_link ); ?>">
								<?php echo esc_html( $cat[0]->name ); ?>
							</a>
						</span>
						<?php
					endif;
				?>
			</div>
			<?php } ?>
		</div>

		<div class="post-content">
			<div class="post-inner">
				<div class="meta">
					<?php
					if( 'post' == get_post_type() ){
						?>	
						<div class="post-footer-detail">
							<span class="author-name">
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<span><?php echo esc_html__( 'by:', 'business-gravity' ); ?></span>
									<?php echo get_the_author(); ?>
								</a>
							</span>
							<span class="divider">
								<?php echo esc_html__( '|', 'business-gravity' ); ?>
							</span>
							<span class="comment-link">
								<a href="<?php comments_link(); ?>">
									<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>
								</a>
							</span>
						</div>
					<?php } ?>
					<?php if( get_edit_post_link()){
						business_gravity_edit_link();
					} ?>
				</div>
				<?php if( 'post' == get_post_type() ): ?>
					<div class="post-format-outer">
						<span class="post-format">
							<span class="kfi <?php echo esc_attr( business_gravity_get_icon_by_post_format() ); ?>"></span>
						</span>
					</div>
				<?php endif; ?>
			</div>
			<header class="post-title">
				<h3>
					<a href="<?php the_permalink(); ?>">
						<?php echo get_the_title(); ?>
					</a>
				</h3>
			</header>
			<div class="post-text"><?php business_gravity_excerpt( 15, true, '&hellip;' ); ?></div>
			<div class="button-container">
				<a href="<?php the_permalink(); ?>" class="button-text">
					<?php esc_html_e( 'Learn More', 'business-gravity' ); ?>
				</a>
			</div>
		</div>
	</article>
</div>
