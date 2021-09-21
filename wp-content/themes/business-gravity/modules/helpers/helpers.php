<?php
/**
* All the general Helper functions lives here
* @since Business Gravity 1.0.0
*/

if( !function_exists( 'business_gravity_enqueue' ) ):
/**
* Enqueue scripts or styles
* 
* @since Business Gravity 1.0.0
* @return void
*/
function business_gravity_enqueue( $scripts ){

    # Do not enqueue anything if no array is supplied.
    if( ! is_array( $scripts ) ) return;

    $scripts = apply_filters( 'business_gravity_scripts' , $scripts );

    foreach ( $scripts as $script ) {

        # Do not try to enqueue anything if handler is not supplied.
        if( ! isset( $script[ 'handler' ] ) )
            continue;

        # use get_theme_file_uri(). So that child theme can overwrite it.
        # @link  https://developer.wordpress.org/reference/functions/get_theme_file_uri/

        if( ! isset( $script[ 'version' ] ) ){
            $version = null;
        }

        # Enqueue each vendor's style
        if( isset( $script[ 'style' ] ) ){
            
            $path = get_theme_file_uri( '/assets/vendors/' . $script[ 'style' ] );
            if( isset( $script[ 'absolute' ] ) ){
                $path = $script[ 'style' ];
            }

            $dependency = array();
            if( isset( $script[ 'dependency' ] ) ){
                $dependency = $script[ 'dependency' ];
            }
            wp_enqueue_style( $script[ 'handler' ], $path, $dependency, $version );
        }

        # Enqueue each vendor's script
        if( isset( $script[ 'script' ] ) ){

            $path = get_theme_file_uri( '/assets/vendors/' . $script[ 'script' ] );
            if( isset( $script[ 'absolute' ] ) ){
                $path = $script[ 'script' ];
            }

            $dependency = array( 'jquery' );
            if( isset( $script[ 'dependency' ] ) ){
                $dependency = $script[ 'dependency' ];
            }

            $prefix = '';
            if( isset( $script[ 'prefix' ] ) ){
                $prefix = $script[ 'prefix' ];
            }
            wp_enqueue_script( $prefix . $script[ 'handler' ], $path, $dependency, $version, true );
        }
    }
}
endif;

if( ! function_exists( 'business_gravity_get_related_posts' ) ):
/**
* Get related posts
*
* @since Business Gravity 1.0.0
* @param array $taxonomy
* @param int $per_page Default 3
* @return bool | object
* 
*/
function business_gravity_get_related_posts( $taxonomy = array(), $per_page = 3, $get_params = false ){
   
    # Show related posts only in single page.
    if ( !is_single() )
        return false;

    # Get the current post object to start of
    $current_post = get_queried_object();

    # Get the post terms, just the ids
    $terms = wp_get_post_terms( $current_post->ID, $taxonomy, array( 'fields' => 'ids' ) );

    # Lets only continue if we actually have post terms and if we don't have an WP_Error object. If not, return false
    if ( !$terms || is_wp_error( $terms ) )
        return false;
    
    # Check if the users argument is valid
    if( is_array( $taxonomy ) && count( $taxonomy ) > 0 ){

    	$tax_query_arg = array();

    	foreach( $taxonomy as $tax ){

    		$tax = filter_var( $tax, FILTER_SANITIZE_STRING );

		    if ( taxonomy_exists( $tax ) ){

		    	array_push( $tax_query_arg, array(
		    		'taxonomy'         => $tax,
		    		'terms'            => $terms,
		    		'include_children' => false
		    	) );
	        	
		    }
    	}

    	if( count( $tax_query_arg ) == 0 ){
    		return false;
    	}

    	if( count( $tax_query_arg ) > 1 ){
    		$tax_query_arg[ 'relation' ] = 'OR';
    	}
    	
    }else
        return false;
    
    # Set the default query arguments
    $args = array(
        'post_type'      => $current_post->post_type,
        'post__not_in'   => array( $current_post->ID ),
        'posts_per_page' => $per_page,
        'tax_query'      => $tax_query_arg,
    );

    if( $get_params ){
        return $args;
    }
    
    # Now we can query our related posts and return them
    $q = get_posts( $args );

    return $q;
}
endif;

/**
* Adds a class 'clearfix' on post navigation markup 	
*	
* @since Business Gravity 1.0.0	
* @param string $template	
* @param string $class	
* @return string	
*/	
function business_gravity_modify_post_navigation_markup( $template, $class ){

	$pos = strpos( $template,'%1$s' );
	$template = substr_replace( $template, 'clearfix ', $pos, 0 );
	
	return $template;

}
add_filter( 'navigation_markup_template', 'business_gravity_modify_post_navigation_markup', 10, 2 );

if( ! function_exists( 'business_gravity_primary_menu_fb' ) ) :
/**
 * Fallback for primary menu.
 *
 * @since Business Gravity 1.0.0
 * @return void
 */
function business_gravity_primary_menu_fb( $arg ) {
    if( !$arg[ 'echo' ] ){
        ob_start();
    }
    ?>
    <ul>
        <li>
            <a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php esc_html_e( 'Home', 'business-gravity' ) ?></a>
        </li>
    </ul>
    <?php
    if( !$arg[ 'echo' ] ){
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}
endif;

if( !function_exists( 'business_gravity_get_youtube_id' ) ):
/**
 * Returns youtubes video id from the url.
 *
 * @since Business Gravity 1.0.0
 * @param string $url
 * @return string | bool
 */
function business_gravity_get_youtube_id( $url ) {

    $parts = parse_url( $url );

    if( isset( $parts[ 'query' ] ) ){

        parse_str( $parts[ 'query' ], $qs );

        if( isset( $qs[ 'v' ] ) ){
            return $qs[ 'v' ];
        }else if( isset( $qs[ 'vi' ] ) ){
            return $qs[ 'vi' ];
        }
    }

    if( isset( $parts[ 'path' ] ) ){
        $path = explode( '/', trim( $parts[ 'path' ], '/' ) );
        return $path[ count( $path )-1 ];
    }
    return false;
}
endif;


if( ! function_exists( 'business_gravity_get_the_category' ) ):
/**
* Returns categories after sorting by term id descending
* 
* @since Business Gravity 1.2
* @uses business_gravity_sort_category()
* @return array
*/
function business_gravity_get_the_category( $id = false ){
    $failed = true;

    if( !$id ){
        $id = get_the_id();
    }
    
    # Check if Yoast Plugin is installed 
    # If yes then, get Primary category, set by Plugin

    if ( class_exists( 'WPSEO_Primary_Term' ) ){

        # Show the post's 'Primary' category, if this Yoast feature is available, & one is set
        $wpseo_primary_term = new WPSEO_Primary_Term( 'category', $id );
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();

        $cat[0] = get_term( $wpseo_primary_term );

        if ( !is_wp_error( $cat[0] ) ) { 
           $failed = false;
        }
    }

    if( $failed ){

      $cat = get_the_category( $id );
      usort( $cat, 'business_gravity_sort_category' );  
    }
    
    return $cat;
}

endif;

if( ! function_exists( 'business_gravity_sort_category' ) ):
/**
* Helper function for business_gravity_get_the_category()
*
* @since Business Gravity 1.0.0
*/
function business_gravity_sort_category( $a, $b ){
    return $a->term_id < $b->term_id;
}
endif;

if( ! function_exists( 'business_gravity_explode_string_to_int' ) ):
/**
* Converts string to an array
* 
* @since Business Gravity 1.0.0
* @param String
* @return array of integers | false
*/
function business_gravity_explode_string_to_int( $str ){
    if( empty( $str ) )
        return false;

    $str = explode( ',', $str );
    $arr = array();

    if( count( $str ) > 0 ){

        foreach( $str as $word ){

            $int = absint( $word );
            if( $int > 0 && ! in_array( $int, $arr ) ){
                $arr[] = $int;
            }
        }
    }

    if( count( $arr ) > 0 )
        return $arr;

    return false;
}
endif;


if( ! function_exists( 'business_gravity_get_menu' ) ):
/**
* Returns wp nav
*
* @since Business Gravity 1.0.0
* @param String $location
* @return String
*/
function business_gravity_get_menu( $location = 'primary', $echo = true ){

    $menu = null;

    $args = array(
        'menu'           => '',
        'theme_location' => $location,
        'fallback_cb'    => false,
        'echo'           => $echo,
        'container'      => false
    );
    switch( $location ){

        case 'primary':
            $args[ 'fallback_cb' ] = 'business_gravity_primary_menu_fb';
            $args[ 'menu_id' ] = 'primary-menu';
            $args[ 'menu_class' ] = 'primary-menu';
            $menu = wp_nav_menu( apply_filters( 'business_gravity_'.$location.'_menu', $args ) );
        break;

        case 'topheader':
            $args[ 'fallback_cb' ] = 'business_gravity_top_header_menu_fb';
            $args[ 'menu_id' ] = 'top-header-menu';
            $args[ 'menu_class' ] = 'top-header-menu';
            $menu = wp_nav_menu( apply_filters( 'business_gravity_'.$location.'_menu', $args ) );
        break;

        case 'social':
            $args[ 'depth' ] = 1;
            $menu = wp_nav_menu( apply_filters( 'business_gravity_'.$location.'_menu', $args ) );
        break;
        
        default:
            $menu = wp_nav_menu( apply_filters( 'business_gravity_'.$location.'_menu', $args ) );
        break;
    }

    if( !$echo ){
        return $menu;
    }
}
endif;

if( !function_exists( 'business_gravity_hex2rgba' ) ):
/**
* Convert hexdec color string to rgb(a) string
* @since Business Gravity 1.0.0
*/
function business_gravity_hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    # Return default if no color provided
    if( empty( $color ) )
          return $default; 
 
    # Sanitize $color if "#" is provided 
    if ( $color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    # Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }
 
    # Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    # Check if opacity is set(rgba or rgb)
    if( $opacity ){
        if( abs( $opacity ) > 1 )
            $opacity = 1.0;
        $output = 'rgba('.implode( ",",$rgb ).','.$opacity.')';
    } else {
        $output = 'rgb('.implode( ",",$rgb ).')';
    }

    # Return rgb(a) color string
    return $output;
}
endif;