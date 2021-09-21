<?php
/**
* Business Gravity breadcrumb.
*
* @since Business Gravity 1.0.0
* @uses breadcrumb_trail()
*/
require get_parent_theme_file_path( '/modules/breadcrumbs/breadcrumbs.php' );
if ( ! function_exists( 'business_gravity_breadcrumb' ) ) :

	function business_gravity_breadcrumb() {

		$breadcrumb_args = apply_filters( 'business_gravity_breadcrumb_args', array(
			'show_browse' => false,
		) );

		breadcrumb_trail( $breadcrumb_args );
	}

endif;

function business_gravity_modify_breadcrumb( $crumb ){

	$i = count( $crumb ) - 1;
	$title = $crumb[ $i ];

	$crumb[ $i ] = $title;

	return $crumb;
}
add_filter( 'breadcrumb_trail_items', 'business_gravity_modify_breadcrumb' );