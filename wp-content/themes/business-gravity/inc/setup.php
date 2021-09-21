<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Business Gravity 1.0.0
 */
function business_gravity_setup() {

	/*
 	 * Make theme available for translation.
 	*/
	load_theme_textdomain( 'business-gravity', get_template_directory() . '/languages' );

	# Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	# Set the default content width.
	$GLOBALS['content_width'] = apply_filters( 'business_gravity_content_width', 1050 );

	# Register menu locations.
	register_nav_menus( array(
		'primary'    => esc_html__( 'Primary Menu', 'business-gravity' ),
		'social'     => esc_html__( 'Social Menu', 'business-gravity' ),
		'footer'     => esc_html__( 'Footer Menu', 'business-gravity' )
	));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-header', array(
		'default-image'    => get_parent_theme_file_uri( '/assets/images/placeholder/business-gravity-banner-1920-380.jpg' ),
		'width'            => 1920,
		'height'           => 380,
		'flex-height'      => true,
		'wp-head-callback' => 'business_gravity_header_style',
	));

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/placeholder/business-gravity-banner-1920-380.jpg',
			'thumbnail_url' => '%s/assets/images/placeholder/business-gravity-banner-1920-380.jpg',
			'description'   => esc_html__( 'Default Header Image', 'business-gravity' ),
		),
	) );

	# Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
	));

	# Enable support for selective refresh of widgets in Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	# Enable support for custom logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 190,
		'height'      => 50,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	add_theme_support( 'infinite-scroll', array(
	    'container' 	 => '#main-wrap',
	    'footer_widgets' => true,
	    'render'         => 'business_gravity_infinite_scroll_render',
	));

	add_theme_support( 'woocommerce' );

	/*
	* This theme styles the visual editor to resemble the theme style,
	* specifically font, colors, icons, and column width.
	*/
	
	add_editor_style( array( '/assets/css/editor-style.min.css') );

	// Gutenberg support
	add_theme_support( 'editor-color-palette', array(
       	array(
			'name' => esc_html__( 'Tan', 'business-gravity' ),
			'slug' => 'tan',
			'color' => '#E6DBAD',
       	),
       	array(
           	'name' => esc_html__( 'Yellow', 'business-gravity' ),
           	'slug' => 'yellow',
           	'color' => '#FDE64B',
       	),
       	array(
           	'name' => esc_html__( 'Orange', 'business-gravity' ),
           	'slug' => 'orange',
           	'color' => '#ED7014',
       	),
       	array(
           	'name' => esc_html__( 'Red', 'business-gravity' ),
           	'slug' => 'red',
           	'color' => '#D0312D',
       	),
       	array(
           	'name' => esc_html__( 'Pink', 'business-gravity' ),
           	'slug' => 'pink',
           	'color' => '#b565a7',
       	),
       	array(
           	'name' => esc_html__( 'Purple', 'business-gravity' ),
           	'slug' => 'purple',
           	'color' => '#A32CC4',
       	),
       	array(
           	'name' => esc_html__( 'Blue', 'business-gravity' ),
           	'slug' => 'blue',
           	'color' => '#3A43BA',
       	),
       	array(
           	'name' => esc_html__( 'Green', 'business-gravity' ),
           	'slug' => 'green',
           	'color' => '#3BB143',
       	),
       	array(
           	'name' => esc_html__( 'Brown', 'business-gravity' ),
           	'slug' => 'brown',
           	'color' => '#231709',
       	),
       	array(
           	'name' => esc_html__( 'Grey', 'business-gravity' ),
           	'slug' => 'grey',
           	'color' => '#6C626D',
       	),
       	array(
           	'name' => esc_html__( 'Black', 'business-gravity' ),
           	'slug' => 'black',
           	'color' => '#000000',
       	),
   	));

	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-font-sizes', array(
	   	array(
	       	'name' => esc_html__( 'small', 'business-gravity' ),
	       	'shortName' => esc_html__( 'S', 'business-gravity' ),
	       	'size' => 12,
	       	'slug' => 'small'
	   	),
	   	array(
	       	'name' => esc_html__( 'regular', 'business-gravity' ),
	       	'shortName' => esc_html__( 'M', 'business-gravity' ),
	       	'size' => 16,
	       	'slug' => 'regular'
	   	),
	   	array(
	       	'name' => esc_html__( 'larger', 'business-gravity' ),
	       	'shortName' => esc_html__( 'L', 'business-gravity' ),
	       	'size' => 36,
	       	'slug' => 'larger'
	   	),
	   	array(
	       	'name' => esc_html__( 'huge', 'business-gravity' ),
	       	'shortName' => esc_html__( 'XL', 'business-gravity' ),
	       	'size' => 48,
	       	'slug' => 'huge'
	   	)
	));
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );

	add_image_size( 'business-gravity-1920-1200', 1920, 1200, true );
	add_image_size( 'business-gravity-1920-750', 1920, 750, true );
	add_image_size( 'business-gravity-1200-850', 1200, 850, true );
	add_image_size( 'business-gravity-1170-710', 1170, 710, true );
}
add_action( 'after_setup_theme', 'business_gravity_setup' );

if( ! function_exists( 'business_gravity_infinite_scroll_render' ) ):
/**
 * Set the code to be rendered on for calling posts,
 * hooked to template parts when possible.
 *
 * Note: must define a loop.
 */
function business_gravity_infinite_scroll_render(){
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/archive/content', '' );
	endwhile;
	wp_reset_postdata();
}
endif;

if( ! function_exists( 'business_gravity_header_style' ) ):
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see business_gravity_setup().
 */
function business_gravity_header_style(){
	$header_text_color = get_header_textcolor();

	# If no custom options for text are set, let's bail.
	# get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	# If we get this far, we have custom styles. Let's do this.
	?>
	<style id="business-gravity-custom-header-styles" type="text/css">
		.wrap-inner-banner .page-header .page-title,
		body.home.page .wrap-inner-banner .page-header .page-title {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	</style>
<?php
}
endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @since Business Gravity 1.0.0
 */
function business_gravity_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'business-gravity' ),
		'id'            => 'right-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'business-gravity' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for( $i = 1; $i <= 4; $i++ ){
		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'business-gravity' ) . $i,
			'id'            => 'business-gravity-footer-sidebar-' . $i,
			'description'   => esc_html__( 'Add widgets here.', 'business-gravity' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="footer-item">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	

}
add_action( 'widgets_init', 'business_gravity_widgets_init' );