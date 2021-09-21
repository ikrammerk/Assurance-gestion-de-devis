<?php
/**
* Sets the panels and returns to Businessgravity_Customizer
*
* @since  Business Gravity 1.0.0
* @param  array An array of the panels
* @return array
*/
function Businessgravity_Customizer_panels( $panels ){

	$panels = array(
		'frontpage_options' => array(
			'title' => esc_html__( 'Front Page Options', 'business-gravity' )
		),
		'theme_options' => array(
			'title' => esc_html__( 'Theme Options', 'business-gravity' )
		)
	);

	return $panels;	
}
add_filter( 'Businessgravity_Customizer_panels', 'Businessgravity_Customizer_panels' );