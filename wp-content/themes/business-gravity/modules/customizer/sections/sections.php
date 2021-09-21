<?php
/**
* Sets sections for Businessgravity_Customizer
*
* @since  Business Gravity 1.0.0
* @param  array $sections
* @return array Merged array
*/
function Businessgravity_Customizer_sections( $sections ){

	$business_gravity_sections = array(
		
		# Section for Fronpage panel
		'slider' => array(
			'title' => esc_html__( 'Slider', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_service' => array(
			'title' => esc_html__( 'Service', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_about' => array(
			'title' => esc_html__( 'About', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_portfolio' => array(
			'title' => esc_html__( 'Portfolio', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_testimonial' => array(
			'title' => esc_html__( 'Testimonial', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_callback' => array(
			'title' => esc_html__( 'Callback', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_highlight' => array(
			'title' => esc_html__( 'Highlight Posts', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_contact' => array(
			'title' => esc_html__( 'Contact', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),
		'home_footer_callback' => array(
			'title' => esc_html__( 'Footer Callback', 'business-gravity' ),
			'panel' => 'frontpage_options'
		),

		# Section for Theme Options panel
		'header_options' => array(
			'title' => esc_html__( 'Header Options', 'business-gravity' ),
			'panel' => 'theme_options'
		),
		'layout_options' => array(
			'title' => esc_html__( 'Layout Options', 'business-gravity' ),
			'panel' => 'theme_options'
		),
		'blog_options' => array(
			'title' => esc_html__( 'Blog Options', 'business-gravity' ),
			'panel' => 'theme_options'
		),
		'footer_options' => array(
			'title' => esc_html__( 'Footer Options', 'business-gravity' ),
			'panel' => 'theme_options'
		)
	);

	return array_merge( $business_gravity_sections, $sections );
}
add_filter( 'Businessgravity_Customizer_sections', 'Businessgravity_Customizer_sections' );