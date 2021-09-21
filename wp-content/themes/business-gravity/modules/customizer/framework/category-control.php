<?php
/**
* Custom Category Control for customizer
*
* @since Business Gravity 1.0.0
*/
if ( class_exists( 'WP_Customize_Control' ) ) :

    class Businessgravity_Customize_Category_Control extends WP_Customize_Control {
        
        /**
        * Generates category dropdown for customizer.
        *
        * @since  Business Gravity 1.0.0
        * @access public
        * @return void
        */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => esc_html__( '&mdash; Select &mdash;', 'business-gravity' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            # Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
    
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span><span class="description customize-control-description">%s</span> %s</label>',
                esc_html( $this->label ),
                esc_html( $this->description ),
                $dropdown
            );
        }
    }
    
endif;