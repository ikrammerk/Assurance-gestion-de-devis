<?php
/**
 * Theme functions and definitions
 *
 * @package insurance_gravity
 */

if ( ! function_exists( 'insurance_gravity_enqueue_styles' ) ) :
	/**
	 * @since Insurance Gravity 1.0.0
	 */
	function insurance_gravity_enqueue_styles() {
		wp_enqueue_style( 'insurance-gravity-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'insurance-gravity-style', get_stylesheet_directory_uri() . '/style.css', array( 'insurance-gravity-style-parent' ), '1.0.0' );
		wp_enqueue_style( 'insurance-gravity-google-fonts', '//fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700', false );
	}
endif;
add_action( 'wp_enqueue_scripts', 'insurance_gravity_enqueue_styles', 99 );


function insurance_gravity_customizer_fields( $fileds ) {
	unset( $fileds['header_layout'] );
	unset( $fileds['footer_layout'] );
	return $fileds;
}

add_filter( 'Businessgravity_Customizer_fields', 'insurance_gravity_customizer_fields', 11 );