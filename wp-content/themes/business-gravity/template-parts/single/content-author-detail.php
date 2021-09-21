<?php
/**
 * Template part for displaying author details
 * @since Business Gravity 1.0.0
 */
 ?>
<div class="author-detail">
	<div class="author">
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
		    <?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
		</a>
	</div>
	<div class="author-content <?php echo ( '' !== wpautop( get_the_author_meta( 'description' ) ) ? '' : esc_attr( 'no-author-text' )); ?>">
		<h3 class="author-name">
			<span><?php esc_html_e( 'Post Author:', 'business-gravity' ); ?></span> 
			<?php echo get_the_author(); ?>
		</h3>
		<?php
			if( '' !== wpautop( get_the_author_meta( 'description' ) ) ): ?>
				<div class="text">
					<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
				</div>
		<?php
			endif;
		?>
	</div>
</div>