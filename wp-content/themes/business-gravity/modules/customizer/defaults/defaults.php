<?php
/**
* Generates default options for customizer.
*
* @since  Business Gravity 1.0.0
* @access public
* @param  array $options 
* @return array
*/
	
function business_gravity_default_options( $options ){

	$defaults = array(
		# Site identity
		'site_title'         	         => esc_html__( 'Business Gravity', 'business-gravity' ),
		'site_title_color'   	         => '#10242b',
		'site_tagline'       	         => esc_html__( 'Business WP Theme', 'business-gravity' ),
		'site_tagline_color' 	         => '#4d4d4d',

		# Primary color
		'site_primary_color' 	         => '#9068BE',

		# Primary color
		'site_hover_color' 	             => '#E62739',

		# Slider
		'slider_control'     	         => true,
		'slider_timeout'     	         => 5,
		'slider_autoplay'    	         => true,
		'slider_button_text'             => '',
		'slider_button_url'              => '',
		'disable_slider_button'          => false,
		'disable_slider'    	         => false,

		# Service
		'disable_service'                => false,

		# Callback
		'callback_title'                 => '',
		'callback_button_text'           => '',
		'callback_button_url'            => '',
		'disable_callback'               => false,

		# About
		'disable_about'                  => false,
		
		# Portfolio
		'portfolio_title'                => '',
		'disable_portfolio'              => false,

		# Testimonial
		'testimonial_title'              => '',
		'disable_testimonial'            => false,

		# Highlight
		'highlight_section_title'        => '',
		'highlight_control'     	     => true,
		'highlight_autoplay'    	     => true,
		'disable_highlight'    	         => false,

		# Contact
		'contact_title'            		 => '',
		'disable_contact'          		 => false,

		# Footer Callback
		'footer_callback_title'          => '',
		'footer_callback_button_text'    => '',
		'footer_callback_button_url'     => '',
		'disable_footer_callback'        => false,

		# Theme options
		# Header
		'disable_top_header'             => false,
		'header_button_text'             => '',
		'header_button_url'              => '',
		'disable_header_button'          => false,
		'disable_fixed_header'           => true,
		'top_header_address'             => '',
		'top_header_email'               => '',
		'top_header_phone'               => '',
		'header_layout'                  => 'header_four',

		# Layout
		'archive_layout'			     => 'right',
		'archive_post_layout'            => 'grid',
		'archive_post_image'             => 'default',
		'archive_post_image_alignment'   => 'center',
		'single_layout'			         => 'compact',

		# Blog
		'archive_page_title'			 => '',

		# Footer
		'footer_layout'                  => 'footer_three',
		'enable_scroll_top_in_mobile'    => false,
		'disable_footer_widget'          => false,
		'footer_text'                    => business_gravity_get_footer_text(),
	);

	return array_merge( $options, $defaults );
}
add_filter( 'Businessgravity_Customizer_defaults', 'business_gravity_default_options' );

if( !function_exists( 'business_gravity_get_footer_text' ) ):
/**
* Generate Default footer text
*
* @return string
* @since Business Gravity 1.0.3
*/

function business_gravity_get_footer_text(){
	$text = esc_html__( 'Copyright &copy; All Rights Reserved.', 'business-gravity' );
							
	return $text;
}
endif;