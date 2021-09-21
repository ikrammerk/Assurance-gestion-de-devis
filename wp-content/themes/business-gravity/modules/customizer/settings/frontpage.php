<?php
/**
* Sets setting field for homepage
* 
* @since  Business Gravity 1.0.0
* @param  array $settings
* @return array Merged array of settings
*
*/
function business_gravity_frontpage_settings( $settings ){

	$home_settings = array(
		# Settings for slider
		'slider_page' => array(
			'label'       => esc_html__( 'Add Page IDs for Pages Slider', 'business-gravity' ),
			'section'     => 'slider',
			'type'        => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23. Supports Maximum 3 sliders.', 'business-gravity' )
		),
		'slider_control' => array(
			'label'     => esc_html__( 'Show Slider Control', 'business-gravity' ),
			'section'   => 'slider',
			'type'      => 'checkbox',
			'transport' => 'postMessage',
		),
		'slider_autoplay' => array(
			'label'   => esc_html__( 'Slider Auto Play', 'business-gravity' ),
			'section' => 'slider',
			'type'    => 'checkbox'
		),
		'slider_timeout' => array(
			'label'    => esc_html__( 'Slider Timeout ( in sec )', 'business-gravity' ),
			'section'  => 'slider',
			'type'     => 'number'
		),
		'slider_button_text' => array(
			'label'     => esc_html__( 'Alternate Slider Button Text', 'business-gravity' ),
			'section'   => 'slider',
			'type'      => 'text',
		),
		'slider_button_url' => array(
			'label'     => esc_html__( 'Alternate Slider Button URL', 'business-gravity' ),
			'section'   => 'slider',
			'type'      => 'text',
		),
		'disable_slider_button' => array(
			'label'     => esc_html__( 'Disable Alternate Slider Button', 'business-gravity' ),
			'section'   => 'slider',
			'type'      => 'checkbox',
		),
		'disable_slider' => array(
			'label'   => esc_html__( 'Disable Slider Section', 'business-gravity' ),
			'section' => 'slider',
			'type'    => 'checkbox',
		),
		
		# Settings for service section
		'service_main_page'  => array(
			'label'   => esc_html__( 'Select Service Page', 'business-gravity' ),
			'section' => 'home_service',
			'type'    => 'dropdown-pages',
		),
		'service_page' => array(
			'label'   => esc_html__( 'Service Page', 'business-gravity' ),
			'section' => 'home_service',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-gravity' )
		),
		'disable_service' => array(
			'label'   => esc_html__( 'Disable Service Section', 'business-gravity' ),
			'section' => 'home_service',
			'type'    => 'checkbox',
		),
		
		# Settings for about page
		'about_page'  => array(
			'label'   => esc_html__( 'Select About Page', 'business-gravity' ),
			'section' => 'home_about',
			'type'    => 'dropdown-pages',
		),
		'disable_about' => array(
			'label'   => esc_html__( 'Disable About Us Section', 'business-gravity' ),
			'section' => 'home_about',
			'type'    => 'checkbox',
		),

		# Settings for callback section
		'callback_image' => array(
			'label'   => esc_html__( 'Background Image', 'business-gravity' ),
			'section' => 'home_callback',
			'type'    => 'image',
		),
		'callback_title' => array(
			'label'   => esc_html__( 'Title', 'business-gravity' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'callback_button_text' => array(
			'label'   => esc_html__( 'Button Text', 'business-gravity' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'callback_button_url' => array(
			'label'   => esc_html__( 'Button URL', 'business-gravity' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'disable_callback' => array(
			'label'   => esc_html__( 'Disable Callback Section', 'business-gravity' ),
			'section' => 'home_callback',
			'type'    => 'checkbox',
		),
		
		# Settings for portfolio section
		'portfolio_title' => array(
			'label'   => esc_html__( 'Enter Title Page for Portfolio', 'business-gravity' ),
			'section' => 'home_portfolio',
			'type'    => 'text',
		),

		'portfolio_page' => array(
			'label'   => esc_html__( 'Portfolio Page', 'business-gravity' ),
			'section' => 'home_portfolio',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-gravity' )
		),
		'disable_portfolio' => array(
			'label'   => esc_html__( 'Disable Portfolio Section', 'business-gravity' ),
			'section' => 'home_portfolio',
			'type'    => 'checkbox',
		),

		# Settings for Testimonials
		'testimonial_title' => array(
			'label'   => esc_html__( 'Testimonial Section Title', 'business-gravity' ),
			'section' => 'home_testimonial',
			'type'    => 'text',
		),
		'testimonial_page' => array(
			'label'   => esc_html__( 'Testimonial Pages', 'business-gravity' ),
			'section' => 'home_testimonial',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-gravity' )
		),
		'disable_testimonial' => array(
			'label'   => esc_html__( 'Disable Testimonial Section', 'business-gravity' ),
			'section' => 'home_testimonial',
			'type'    => 'checkbox',
		),

		# Settings for highlight
		'highlight_section_title' => array(
			'label'   => esc_html__( 'Highlight Section Title', 'business-gravity' ),
			'section' => 'home_highlight',
			'type'    => 'text',
		),
		'highlight_category' => array(
			'label'   => esc_html__( 'Choose Highlight Category', 'business-gravity' ),
			'section' => 'home_highlight',
			'type'    => 'dropdown-categories',
		),
		'highlight_control' => array(
			'label'     => esc_html__( 'Show Slider Control', 'business-gravity' ),
			'section'   => 'home_highlight',
			'type'      => 'checkbox',
			'transport' => 'postMessage',
		),
		'highlight_autoplay' => array(
			'label'   => esc_html__( 'Slider Auto Play', 'business-gravity' ),
			'section' => 'home_highlight',
			'type'    => 'checkbox'
		),
		'disable_highlight' => array(
			'label'   => esc_html__( 'Disable Highlight Section', 'business-gravity' ),
			'section' => 'home_highlight',
			'type'    => 'checkbox',
		),

		# Settings for Contact
		'contact_title' => array(
			'label'   => esc_html__( 'Contact Section Title', 'business-gravity' ),
			'section' => 'home_contact',
			'type'    => 'text',
		),
		'contact_shortcode' => array(
			'label'   => esc_html__( 'Shortcode', 'business-gravity' ),
			'section' => 'home_contact',
			'description' => esc_html__( 'Add a Contact Form 7 Shortcode.', 'business-gravity' ),
			'type'    => 'text',
		),
		'disable_contact' => array(
			'label'   => esc_html__( 'Disable Contact Section', 'business-gravity' ),
			'section' => 'home_contact',
			'type'    => 'checkbox',
		),

		# Settings for footer callback section
		'footer_callback_image' => array(
			'label'   => esc_html__( 'Background Image', 'business-gravity' ),
			'section' => 'home_footer_callback',
			'type'    => 'image',
		),
		'footer_callback_title' => array(
			'label'   => esc_html__( 'Title', 'business-gravity' ),
			'section' => 'home_footer_callback',
			'type'    => 'text',
		),
		'footer_callback_shortcode' => array(
			'label'   => esc_html__( 'Shortcode', 'business-gravity' ),
			'section' => 'home_footer_callback',
			'description' => esc_html__( 'Add a MailChimp for WordPress Shortcode.', 'business-gravity' ),
			'type'    => 'text',
		),
		'disable_footer_callback' => array(
			'label'   => esc_html__( 'Disable Footer Callback Section', 'business-gravity' ),
			'section' => 'home_footer_callback',
			'type'    => 'checkbox',
		),
	);

	return array_merge( $home_settings, $settings );
}
add_filter( 'Businessgravity_Customizer_fields', 'business_gravity_frontpage_settings' );