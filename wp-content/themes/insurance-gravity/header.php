<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Insurance Gravity 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="site-loader">
		<div class="site-loader-inner">
			<?php
				$src = get_theme_file_uri( 'assets/images/placeholder/loader.gif' );
				echo apply_filters( 'business_gravity_preloader',
				sprintf( '<img src="%s" alt="%s">',
					esc_url( $src ),
					esc_html__( 'Site Loader', 'insurance-gravity' )
				)); 
			?>
		</div>
	</div>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content">
			<?php echo esc_html__( 'Skip to content', 'insurance-gravity' ); ?>
		</a>
		<?php get_template_part( 'template-parts/header/offcanvas', 'menu' ); ?>

		<header class="wrapper top-header">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-7 d-none d-lg-block">
						<?php get_template_part( 'template-parts/header/header', 'contact' ); ?>
					</div>
					<div class="col-6 col-lg-5 d-none d-lg-block">
						<div class="top-header-right">
							<div class="socialgroup">
								<?php business_gravity_get_menu( 'social' ); ?>
							</div>
							<?php get_template_part('template-parts/header/header', 'cart'); ?>
							<?php get_template_part('template-parts/header/header', 'search'); ?>
						</div>
					</div>
				</div>
			</div>
		</header><!-- top header -->

		<?php
		if ( !business_gravity_get_option( 'disable_fixed_header') ):
		?>
		<header id="fixed-header" class="wrapper wrap-fixed-header" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-9 col-lg-3">
						<?php get_template_part( 'template-parts/header/fixedheader', 'sitebranding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ? $class = 'col-lg-7' : $class = 'col-lg-9'; ?>
					<div class="col-6 <?php echo esc_attr( $class ); ?>" id="primary-nav-container">
						<div class="wrap-nav main-navigation">
							<div id="navigation" class="d-none d-lg-block">
							    <nav class="site-navigation">
									<?php echo business_gravity_get_menu( 'primary' ); ?>
							    </nav>
							</div>
						</div>
						<span class="alt-menu-icon d-lg-none">
							<a class="offcanvas-menu-toggler" href="#">
								<span class="kfi kfi-menu"></span>
							</a>
						</span>
					</div>
					<?php if( !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ): ?>
					<div class="col-lg-2" id="header-bottom-right-outer">
						<div class="header-bottom-right">
							<?php get_template_part('template-parts/header/header', 'callback'); ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</header><!-- fix header -->
		<?php endif; ?>

		<header id="masthead" class="wrapper site-header site-header-four" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-3">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ? $class = 'col-lg-7' : $class = 'col-lg-9'; ?>
					<div class="col-6 <?php echo esc_attr( $class ); ?>" id="primary-nav-container">
						<div id="navigation" class="wrap-nav d-none d-lg-block">
						    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'insurance-gravity' ); ?>">
						    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'insurance-gravity' ); ?></button>
								<?php echo business_gravity_get_menu( 'primary' ); ?>
						    </nav>
						</div>
						<span class="alt-menu-icon d-lg-none">
							<a class="offcanvas-menu-toggler" href="#">
								<span class="kfi kfi-menu"></span>
							</a>
						</span>
					</div>
					<?php if( !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ): ?>
						<div class="col-lg-2" id="header-bottom-right-outer">
							<div class="header-bottom-right">
								<?php get_template_part('template-parts/header/header', 'callback'); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header> <!-- header -->
	<div id="content" class="wrapper site-main">