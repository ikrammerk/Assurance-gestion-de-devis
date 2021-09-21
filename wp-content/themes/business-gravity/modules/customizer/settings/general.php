<?php
/**
* Sets settings for general fields
*
* @since  Business Gravity 1.0.0
* @param  array $settings
* @return array Merged array
*/

function Businessgravity_Customizer_general_settings( $settings ){

	$general = array(
		# Site identity
		'fixed_header_logo' => array(
			'label'   => esc_html__( 'Alternet Logo for Fixed Header', 'business-gravity' ),
			'section' => 'title_tagline',
			'type'    => 'image',
		),

		# Color
		'site_title_color' => array(
			'label'     => esc_html__( 'Site Title', 'business-gravity' ),
			'transport' => 'postMessage',
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_tagline_color' => array(
			'label'     => esc_html__( 'Site Tagline', 'business-gravity' ),
			'transport' => 'postMessage',
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_primary_color' => array(
			'label'     => esc_html__( 'Primary', 'business-gravity' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_hover_color' => array(
			'label'     => esc_html__( 'Hover', 'business-gravity' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),

		# Theme Options
		# Header
		'top_header_address' => array(
			'label'   => esc_html__( 'Address', 'business-gravity' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'top_header_email' => array(
			'label'   => esc_html__( 'Email', 'business-gravity' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'top_header_phone' => array(
			'label'   => esc_html__( 'Phone', 'business-gravity' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'disable_top_header' => array(
			'label'     => esc_html__( 'Disable Top Header', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),
		'header_layout' => array(
			'label'     => esc_html__( 'Select Header Layout', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'select',
			'choices'   => array(
				'header_one'   => esc_html__( 'Header Layout One', 'business-gravity' ),
				'header_two'   => esc_html__( 'Header Layout Two', 'business-gravity' ),
				'header_three' => esc_html__( 'Header Layout Three', 'business-gravity' ),
				'header_four'  => esc_html__( 'Header Layout Four', 'business-gravity' ),
			),
		),
		'header_button_text' => array(
			'label'     => esc_html__( 'Header Button Text', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'text',
		),
		'header_button_url' => array(
			'label'     => esc_html__( 'Header Button URL', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'text',
		),
		'disable_header_button' => array(
			'label'     => esc_html__( 'Disable Header Button', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),
		'disable_fixed_header' => array(
			'label'     => esc_html__( 'Disable Fixed Header', 'business-gravity' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),
		# Layout
		'archive_layout' => array(
			'label'     => esc_html__( 'Archive Layout', 'business-gravity' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'left' => esc_html__( 'Left Sidebar', 'business-gravity' ),
				'right' => esc_html__( 'Right Sidebar', 'business-gravity' ),
				'none' => esc_html__( 'No Sidebar', 'business-gravity' ),
			),
		),
		'archive_post_layout' => array(
			'label'     => esc_html__( 'Archive Post Layout', 'business-gravity' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'grid' => esc_html__( 'Grid', 'business-gravity' ),
				'simple' => esc_html__( 'Simple', 'business-gravity' ),
			),
		),
		'archive_post_image' => array(
			'label'     => esc_html__( 'Archive Post Image', 'business-gravity' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'thumbnail' => esc_html__( 'Thumbnail (150x150)', 'business-gravity' ),
				'medium' => esc_html__( 'Medium (300x300)', 'business-gravity' ),
				'large' => esc_html__( 'Large (1024x1024)', 'business-gravity' ),
				'default' => esc_html__( 'Default (1170x960)', 'business-gravity' ),
			),
		),
		'archive_post_image_alignment' => array(
			'label'     => esc_html__( 'Archive Post Image Alignment', 'business-gravity' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'left' => esc_html__( 'Left', 'business-gravity' ),
				'right' => esc_html__( 'Right', 'business-gravity' ),
				'center' => esc_html__( 'Center', 'business-gravity' ),
			),
		),
		'single_layout' => array(
			'label'     => esc_html__( 'Single Page Layout', 'business-gravity' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'left' => esc_html__( 'Left Sidebar', 'business-gravity' ),
				'right' => esc_html__( 'Right Sidebar', 'business-gravity' ),
				'compact' => esc_html__( 'Compact', 'business-gravity' ),
			),
		),
		# Blog
		'archive_page_title' => array(
			'label'   => esc_html__( 'Blog Page Title', 'business-gravity' ),
			'section' => 'blog_options',
			'type'    => 'text',
		),
		# Footer
		'footer_layout' => array(
			'label'     => esc_html__( 'Select Footer Layout', 'business-gravity' ),
			'section'   => 'footer_options',
			'type'      => 'select',
			'choices'   => array(
				'footer_one'   => esc_html__( 'Footer Layout One', 'business-gravity' ),
				'footer_two'   => esc_html__( 'Footer Layout Two', 'business-gravity' ),
				'footer_three' => esc_html__( 'Footer Layout Three', 'business-gravity' ),
			),
		),
		'enable_scroll_top_in_mobile' => array(
			'label'     => esc_html__( 'Enable Scroll top in mobile', 'business-gravity' ),
			'section'   => 'footer_options',
			'transport' => 'postMessage',
			'type'      => 'checkbox',
		),
		'disable_footer_widget' => array(
			'label'   => esc_html__( 'Disable Footer Widget', 'business-gravity' ),
			'section' => 'footer_options',
			'type'    => 'checkbox',
		),
		'footer_text' =>  array(
			'label'     => esc_html__( 'Footer Text', 'business-gravity' ),
			'section'   => 'footer_options',
			'type'      => 'textarea',
		)
	);

	return array_merge( $settings, $general );
}
add_filter( 'Businessgravity_Customizer_fields', 'Businessgravity_Customizer_general_settings' );