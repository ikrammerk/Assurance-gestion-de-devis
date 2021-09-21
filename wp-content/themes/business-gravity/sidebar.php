<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Business Gravity 1.0.0
 */

if ( ! is_active_sidebar( 'right-sidebar' ) ) {
	return;
}
?>

<div class="col-12 col-md-4">
	<sidebar class="sidebar clearfix" id="primary-sidebar">
	<?php dynamic_sidebar( 'right-sidebar' ); ?>
	</sidebar>
</div>