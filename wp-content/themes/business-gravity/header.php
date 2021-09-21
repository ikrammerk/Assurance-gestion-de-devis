<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Business Gravity 1.0.0
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
<?php do_action( 'wp_body_open' ); ?>

	<div id="site-loader">
		<div class="site-loader-inner">
			<?php
				$src = get_theme_file_uri( 'assets/images/placeholder/loader.gif' );
				echo apply_filters( 'business_gravity_preloader',
				sprintf( '<img src="%s" alt="%s">',
					esc_url( $src ),
					esc_html__( 'Site Loader', 'business-gravity' )
				)); 
			?>
		</div>
	</div>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content">
			<?php echo esc_html__( 'Skip to content', 'business-gravity' ); ?>
		</a>		
		<?php
			$header_two = business_gravity_get_option( 'header_layout' ) == 'header_two';
			if( !business_gravity_get_option( 'disable_top_header' ) && !$header_two ):
		?>
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
		<?php endif; ?>

		<?php
		if ( !business_gravity_get_option( 'disable_fixed_header') ):
		?>
		<header id="fixed-header" class="wrapper wrap-fixed-header" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-3">
						<?php get_template_part( 'template-parts/header/fixedheader', 'sitebranding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ? $class = 'col-lg-7' : $class = 'col-lg-9'; ?>
					<div class="col-6 <?php echo esc_attr( $class ); ?>" id="primary-nav-container">
						<div class="wrap-nav main-navigation">
							<div id="navigation" class="d-none d-lg-block">
							    <nav class="site-navigation">
							    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'business-gravity' ); ?></button>
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
					<div class="col-lg-2 d-none d-lg-inline-block" id="header-bottom-right-outer">
						<div class="header-bottom-right">
							<?php get_template_part('template-parts/header/header', 'callback'); ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</header><!-- fix header -->
		<?php endif; ?>

		<?php
		if( business_gravity_get_option( 'header_layout' ) == 'header_one' ):
		?>
		<header id="masthead" class="wrapper site-header site-header-primary" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-3">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ? $class = 'col-lg-7' : $class = 'col-lg-9'; ?>
					<div class="col-6 <?php echo esc_attr( $class ); ?>" id="primary-nav-container">
						<div id="navigation" class="wrap-nav d-none d-lg-block">
						    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'business-gravity' ); ?>">
						    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'business-gravity' ); ?></button>
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
						<div class=" col-lg-2 d-none d-lg-inline-block" id="header-bottom-right-outer">
							<div class="header-bottom-right">
								<?php get_template_part('template-parts/header/header', 'callback'); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header><!-- primary header / header one -->
		<?php endif; ?>

		<?php
			if( business_gravity_get_option( 'header_layout' ) == 'header_two' ):
		?>
		<header id="masthead" class="wrapper site-header site-header-two" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-9 col-lg-5">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

					</div>
					<div class="col-6 col-lg-7 d-none d-lg-block">
						<?php get_template_part( 'template-parts/header/header', 'contact' ); ?>
					</div>
					<span class="alt-menu-icon d-lg-none col-3">
						<a class="offcanvas-menu-toggler" href="#">
							<span class="kfi kfi-menu"></span>
						</a>
					</span>
				</div>
				<div class="main-header">
					<div class="row align-items-center">
						<div class="d-none d-lg-block col-lg-7" id="primary-nav-container">
							<div class="wrap-nav main-navigation">
								<div id="navigation">
									<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'business-gravity' ); ?>">
								    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'business-gravity' ); ?></button>
										<?php echo business_gravity_get_menu( 'primary' ); ?>
								    </nav>
								</div>
							</div>
						</div>
						<div class="col-lg-5" id="header-bottom-right-outer">
							<div class="top-header">
								<div class="header-bottom-right">
									<div class="top-header-right d-none d-lg-block">
										<div class="socialgroup">
											<?php business_gravity_get_menu( 'social' ); ?>
										</div>
										<?php if( class_exists( 'WooCommerce' ) ): ?>
											<span class="cart-icon">
												<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
													<span class="kfi kfi-cart-alt"></span>
													<span class="count">
														<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>
													</span>
												</a>
											</span>
										<?php endif; ?>
										<?php if( !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ): ?>
										<div class="d-none d-lg-inline-block">
											<?php get_template_part('template-parts/header/header', 'callback'); ?>
										</div>
										<?php endif; ?>
										<?php get_template_part('template-parts/header/header', 'search'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header> <!-- header two -->
		<?php endif;

		if( business_gravity_get_option( 'header_layout' ) == 'header_three' ):
		?>
		<header id="masthead" class="wrapper site-header site-header-three" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-12">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ? $class = 'col-lg-8' : $class = 'col-lg-12'; ?>
					<div class="col-6 <?php echo esc_attr( $class ); ?>" id="primary-nav-container">
						<div id="navigation" class="wrap-nav d-none d-lg-block">
						    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'business-gravity' ); ?>">
						    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'business-gravity' ); ?></button>
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
					<div class="col-lg-4 d-none d-lg-inline-block" id="header-bottom-right-outer">
						<div class="header-bottom-right">
							<?php get_template_part('template-parts/header/header', 'callback'); ?>
						</div>
					</div>
				<?php endif; ?>
				</div>
			</div>
		</header> <!-- header three -->
		<?php endif;

		if( business_gravity_get_option( 'header_layout' ) == 'header_four' ):
		?>
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
						    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'business-gravity' ); ?>">
						    	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'business-gravity' ); ?></button>
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
						<div class=" col-lg-2" id="header-bottom-right-outer">
							<div class="header-bottom-right">
								<div class="d-none d-lg-inline-block">
									<?php get_template_part('template-parts/header/header', 'callback'); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header> <!-- header four -->
		<?php endif; ?>
		<?php get_template_part( 'template-parts/header/offcanvas', 'menu' ); ?>
		<div id="content" class="wrapper site-main">